<?php

namespace Modules\Shopping\Http\Controllers;

use App\Helpers\CommonMethods;
use App\Helpers\Paypal;
use App\Helpers\RestWrapper;
use App\Helpers\SessionHdl;
use Carbon\Carbon;
use function Couchbase\defaultDecoder;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Mockery\Exception;
use Modules\Admin\Entities\Country;
use Modules\Admin\Http\Controllers\Shopping\OrderController;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\Legal;
use Modules\Shopping\Entities\Order;
use Modules\Shopping\Entities\OrderDetail;
use Modules\Shopping\Entities\OrderDocument;
use Modules\Shopping\Entities\PromoProd;
use Modules\Shopping\Entities\ShippingAddress;
use Modules\Shopping\Entities\WarehouseCountry;

class CronController extends Controller
{
    public function __construct()
    {
        $this->CommonMethods = new CommonMethods();
    }

    /*
     * 1. Listado de Ordenes.
     * 2. Si la orden es tipo Inscription realizar el proceso processInscriptions y si no el proceso processOrder.
     */
    public function getProcess()
    {
        $orders_types = $this->getOrdersToProcess();

        foreach ($orders_types as $order_type)
        {
            foreach ($order_type as $ot)
            {
                if ($ot->so_shop_type == 'Inscription')
                {
                    $this->processInscriptions($ot);
                }
                else if ($ot->so_shop_type == 'Sell')
                {
                    $this->processOrders($ot);
                }
            }
        }
    }

    /*
     * 1. Obtiene el listado de Ordenes a procesar.
     */
    public function getOrdersToProcess()
    {
        $order = new Order();

        return $order->getOrders();
    }

    /*
     * 1. Proceso para Inscripciones.
     * 2. Obtenemos la info de la orden.
     */
    private function processInscriptions($order_type)
    {
        $data   = $this->getOrderInfo($order_type->so_id);

        if ($data)
        {
            $statusAddEntrepreneur = false;
            $statusAddSalesWeb = false;
            $country = Country::find($data->so_country_id);
            $date   = new \DateTime('now', new \DateTimeZone($country->timezone));
            App::setLocale($country->default_locale);

            /* Consumir Servicios AddFormEntrepreneur, AddEntrepreneur y AddSalesWeb */
            if ($data->so_saved_dataeo == 0)
            {
                $paramsTtAddFormEntrepreneur = $this->getTtAddFormEntrepreneur($data);
                $paramsTtAddFormDoctos = $this->getTtAddFormDoctos($data);

                $restWrapperAddFormEntrepreneur = new RestWrapper($country->webservice . 'addFormEntrepreneur');
                $paramsAddFormEntrepreneur = [
                    'request' => [
                        'CountryKey' => $country->corbiz_key,
                        'Lang' => $country->language->corbiz_key,
                        'AddFormEntrepreneur' => [
                            'ttAddFormEntrepreneur' => $paramsTtAddFormEntrepreneur
                        ],
                        'AddFormDoctos' => [
                            'ttAddFormDoctos' => $paramsTtAddFormDoctos
                        ]
                    ]
                ];

                $resultAddFormEntrepreneur = $restWrapperAddFormEntrepreneur->call('POST', $paramsAddFormEntrepreneur, 'json', ['http_errors' => false]);

                if ($resultAddFormEntrepreneur['success'] && $resultAddFormEntrepreneur['responseWS']['response']['Success'] == 'true')
                {
                    $statusAddEntrepreneur = true;
                }
                else if (!$resultAddFormEntrepreneur['success'] && isset($resultAddFormEntrepreneur['responseWS']['response']) && $resultAddFormEntrepreneur['responseWS']['response']['Success'] == 'false' && isset($resultAddFormEntrepreneur['responseWS']['response']['Error']['dsError']['ttError']))
                {
                    $error_corbiz = '';
                    $error_user = '';

                    foreach ($resultAddFormEntrepreneur['responseWS']['response']['Error']['dsError']['ttError'] as $i => $err)
                    {
                        $error_corbiz .= $err['messTech'] . PHP_EOL;
                        $error_user .= $err['messUser'] . PHP_EOL;
                    }

                    $this->updateOrderStatus($data, 'CORBIZ_ERROR', 0, $error_corbiz, $error_user);
                }
                else
                {
                    $this->updateOrderStatus($data, 'CORBIZ_ERROR', 0, isset($resultAddFormEntrepreneur['message']), isset($resultAddFormEntrepreneur['responseWS']['_errors'][0]['_errorMsg']));
                }
            }
            else if ($data->so_saved_dataeo == 1)
            {
                /* Consumir Servicio AddSalesWeb */
                if ($data->so_distributor_number != null || $data->so_distributor_number != '')
                {
                    $statusAddSalesWeb = true;
                }
                /* Consumir Servicios AddEntrepreneur y AddSalesWeb */
                else
                {
                    $statusAddEntrepreneur = true;
                }
            }

            if ($statusAddEntrepreneur)
            {
                $restWrapperAddEntrepreneur = new RestWrapper($country->webservice . 'addEntrepreneur');
                $paramsAddEntrepreneur = [
                    'request' => [
                        'CountryKey' => $country->corbiz_key,
                        'Lang' => $country->language->corbiz_key,
                        'AddEntrepreneur' => [
                            'ttAddEntrepreneur' => [
                                [
                                    'countrySale' => $country->corbiz_key,
                                    'idTransaction' => $data->so_corbiz_transaction
                                ]
                            ],
                        ]
                    ]
                ];

                $resultAddEntrepreneur = $restWrapperAddEntrepreneur->call('POST', $paramsAddEntrepreneur, 'json', ['http_errors' => false]);

                if ($resultAddEntrepreneur['success'] && $resultAddEntrepreneur['responseWS']['response']['Success'] == 'true')
                {
                    $statusAddSalesWeb = true;

                    $this->updateEo($data, $resultAddEntrepreneur['responseWS']['response']['EntrepreneurId']);

                    $emailsSend = Config::get('cms.email_send');
                    $from_email = $emailsSend[$country->corbiz_key];

                    /* Envio de mail sponsor */
                    $data_sponsor = [
                        'view_mail'         => 'shopping::frontend.register.includes.' . strtolower($country->corbiz_key) . '.mails.sponsor',
                        'from_email'        => $from_email,
                        'title'             => trans('shopping::register.mail.sponsor.title'),
                        'to_email'          => $data->ssa_sponsor_email,
                        'name'              => $data->ssa_sponsor_name,
                        'subject'           => trans('shopping::register.mail.sponsor.subject', ['name_sponsor' => $data->ssa_sponsor_name]),
                        'name_customer'     => $data->ssa_eo_name . ' ' . $data->ssa_eo_lastname,
                        'code_customer'     => $resultAddEntrepreneur['responseWS']['response']['EntrepreneurId'],
                        'tel_customer'      => isset($data->ssa_telephone) ? $data->ssa_telephone : $data->ssa_cellphone,
                        'email_customer'    => $data->ssa_email
                    ];

                    if (!empty($from_email) && !empty($data->ssa_sponsor_email))
                    {
                        $this->CommonMethods->getSendMail($data_sponsor);
                    }

                    $eo     = Crypt::encryptString($country->corbiz_key . ' ' . $country->language->corbiz_key . ' ' . $resultAddEntrepreneur['responseWS']['response']['EntrepreneurId'] . ' ' . $resultAddEntrepreneur['responseWS']['response']['Password']);
                    $legal  = Legal::where('country_id', $country->id)->whereTranslation('locale', $country->language->locale_key)->first();

                    /* Envio de mail entrepreneur */
                    $data_customer = [
                        'view_mail'     => 'shopping::frontend.register.includes.' . strtolower($country->corbiz_key) . '.mails.customer',
                        'from_email'    => $from_email,
                        'title'         => trans('shopping::register.mail.customer.title'),
                        'to_email'      => $data->ssa_email,
                        'name'          => $data->ssa_eo_name . ' ' . $data->ssa_eo_lastname,
                        'subject'       => trans('shopping::register.mail.customer.subject'),
                        'code'          => $resultAddEntrepreneur['responseWS']['response']['EntrepreneurId'],
                        'password'      => $resultAddEntrepreneur['responseWS']['response']['Password'],
                        'question'      => $resultAddEntrepreneur['responseWS']['response']['Question'],
                        'answer'        => $data->ssa_answer,
                        'name_sponsor'  => $data->ssa_sponsor_name,
                        'email_sponsor' => $data->ssa_sponsor_email,
                        'url_login'     => '/login?eo=' . $eo,
                        'disclaimer'    => !is_null($legal) && $legal->active_disclaimer == 1 && !empty($legal->disclaimer_html) ? $legal->disclaimer_html : '',
                        'locale'        => $country->language->locale_key,
                    ];

                    /* Contrato */
                    if (!empty($data->so_contract_path))
                    {
                        $data_customer['attachPdf'] = $data->so_contract_path;
                    }
                    else
                    {
                        # Generación del código QR
                        $content    = "date={$data->so_terms_checked}&ip={$data->ssa_public_ip}&country={$country->name}&distributor={$resultAddEntrepreneur['responseWS']['response']['EntrepreneurId']}";
                        $qrInfo     = $this->getQRContractInfo($content, $country->corbiz_key);

                        try
                        {
                            $today = explode('.', date('d.m.y'));

                            $paths = $this->generateContract([
                                'name'       => (!empty($data->ssa_eo_lastnamem) ? "{$data->ssa_eo_lastname} {$data->ssa_eo_lastnamem}, " : "{$data->ssa_eo_lastname}, ") . "{$data->ssa_eo_name} ({$resultAddEntrepreneur['responseWS']['response']['EntrepreneurId']})",
                                'address'    => $data->ssa_address,
                                'city'       => $data->ssa_city,
                                'state'      => $data->ssa_state,
                                'zipCode'    => $data->ssa_zip_code,
                                'birthday'   => date('m-d-Y', strtotime($data->ssa_birthdate)),
                                'email'      => $data->ssa_email,
                                'phone'      => isset($data->ssa_telephone) ? $data->ssa_telephone : '',
                                'cellphone'  => isset($data->ssa_cellphone) ? $data->ssa_cellphone : '',
                                'otherphone' => '',
                                'dd'         => $today[0],
                                'mm'         => $today[1],
                                'yy'         => $today[2],
                                'filename'   => $resultAddEntrepreneur['responseWS']['response']['EntrepreneurId'] . '.pdf'
                            ], $data->so_country_id, $country->language->locale_key, $qrInfo, $country->corbiz_key);

                            if ($paths !== false) {
                                $data_customer['attachPdf']  = $paths['completePath'];
                                Order::where('id', $data->so_id)->update([
                                    'contract_path' => $paths['publicPath'],
                                    'updated_at'    => $date->format('Y-m-d H:i:s')
                                ]);
                            }
                        }
                        catch (\ErrorException $e)
                        {
                            Log::error('ERR resendContract (confirmation): ' . $e->getMessage());
                        }
                    }

                    if (!empty($from_email) && !empty($data->ssa_email))
                    {
                        $this->CommonMethods->getSendMail($data_customer);
                    }
                }
                else if (!$resultAddEntrepreneur['success'] && isset($resultAddEntrepreneur['responseWS']['response']) && $resultAddEntrepreneur['responseWS']['response']['Success'] == 'false' && isset($resultAddEntrepreneur['responseWS']['response']['Error']['dsError']['ttError']))
                {
                    $error_corbiz = '';
                    $error_user = '';

                    foreach ($resultAddEntrepreneur['responseWS']['response']['Error']['dsError']['ttError'] as $i => $err)
                    {
                        $error_corbiz .= $err['messTech'] . PHP_EOL;
                        $error_user .= $err['messUser'] . PHP_EOL;
                    }

                    $this->updateOrderStatus($data, 'CORBIZ_ERROR', 0, $error_corbiz, $error_user);
                }
                else
                {
                    $this->updateOrderStatus($data, 'CORBIZ_ERROR', 0, isset($resultAddEntrepreneur['message']), isset($resultAddEntrepreneur['responseWS']['_errors'][0]['_errorMsg']));
                }
            }

            if ($statusAddSalesWeb)
            {
                $data_update = $this->getOrderInfo($data->so_id);

                $paramsTtSalesWeb = $this->getTtSalesWebParams($data_update);
                $paramsTtSalesWebItems = $this->getTtSalesWebItemsParams($data_update);

                $restWrapperAddSalesWeb = new RestWrapper($country->webservice . 'addSalesWeb');
                $paramsAddSalesWeb = [
                    'request' => [
                        'CountryKey' => $country->corbiz_key,
                        'Lang' => $country->language->corbiz_key,
                        'SalesWeb' => [
                            'ttSalesWeb' => [
                                $paramsTtSalesWeb
                            ],
                        ],
                        'SalesWebItems' => [
                            'ttSalesWebItems' => $paramsTtSalesWebItems
                        ]
                    ]
                ];

                $resultAddSalesWeb = $restWrapperAddSalesWeb->call('POST', $paramsAddSalesWeb, 'json', ['http_errors' => false]);

                if ($resultAddSalesWeb['success'] && $resultAddSalesWeb['responseWS']['response']['Success'] == 'true')
                {
                    $this->updateOrderStatus($data_update, 'ORDER_COMPLETE', $resultAddSalesWeb['responseWS']['response']['Orden'], '', '', $resultAddSalesWeb['responseWS']['response']['Discount']);

                    $supportEmails = Config::get('cms.email_send');
                    $from_email = $supportEmails[$country->corbiz_key];

                    $mail_info = [
                        'first_name'   => $data_update->ssa_eo_name . ' ' . $data_update->ssa_eo_lastname,
                        'order_number' => $resultAddSalesWeb['responseWS']['response']['Orden'],
                        'addr_name'    => $data_update->ssa_eo_name . ' ' . $data_update->ssa_eo_lastname,
                        'address'      => "{$data_update->ssa_address} {$data_update->ssa_city_name}, {$data_update->ssa_state}",
                        'items'        => $this->getItemsToMail($order_type->so_id),
                        'detail'       => $this->getOrderDetail($order_type->so_id),
                    ];

                    $to_mail    = $data_update->ssa_email;
                    $to_name    = $data_update->ssa_eo_name . ' ' . $data_update->ssa_eo_lastname;

                    if (!empty($from_email) && !empty($to_mail))
                    {
                        Mail::send('shopping::frontend.shopping.includes.' . strtolower($country->corbiz_key) . '.mails.payment_success_order_corbiz', $mail_info, function ($m) use ($from_email, $to_mail, $to_name) {
                            $m->from($from_email, trans('shopping::register_customer.mail_address.title'));
                            $m->to($to_mail, $to_name)->subject(trans('shopping::checkout.confirmation.emails.order_success'));
                        });
                    }
                }
                else if (!$resultAddSalesWeb['success'] && isset($resultAddSalesWeb['responseWS']['response']) && $resultAddSalesWeb['responseWS']['response']['Success'] == 'false' && isset($resultAddSalesWeb['responseWS']['response']['Error']['dsError']['ttError']))
                {
                    $error_corbiz = '';
                    $error_user = '';

                    foreach ($resultAddSalesWeb['responseWS']['response']['Error']['dsError']['ttError'] as $i => $err)
                    {
                        $error_corbiz .= $err['messTech'] . PHP_EOL;
                        $error_user .= $err['messUser'] . PHP_EOL;
                    }

                    $this->updateOrderStatus($data_update, 'CORBIZ_ERROR', 0, $error_corbiz, $error_user);

                    Log::error('Request Inscription addSalesWeb Cron: ' . json_encode($paramsAddSalesWeb));
                    Log::error('Response Inscription addSalesWeb Cron: ' . json_encode($resultAddSalesWeb));
                }
                else
                {
                    $this->updateOrderStatus($data_update, 'CORBIZ_ERROR', 0, isset($resultAddSalesWeb['message']), isset($resultAddSalesWeb['responseWS']['_errors'][0]['_errorMsg']));

                    Log::error('Request Inscription addSalesWeb Cron: ' . json_encode($paramsAddSalesWeb));
                    Log::error('Response Inscription addSalesWeb Cron: ' . json_encode($resultAddSalesWeb));
                }
            }
        }
        else
        {
            Log::error('Inscription Cron: Sin peticiones por procesar.');
        }
    }

    private function processOrders($order_type)
    {
        $data = $this->getOrderInfo($order_type->so_id);

        if ($data)
        {
            $country = Country::find($data->so_country_id);
            $paramsTtSalesWeb = $this->getTtSalesWebParams($data);
            $paramsTtSalesWebItems = $this->getTtSalesWebItemsParams($data);
            App::setLocale($country->default_locale);

            $restWrapperAddSalesWeb = new RestWrapper($country->webservice . 'addSalesWeb');
            $paramsAddSalesWeb = [
                'request' => [
                    'CountryKey' => $country->corbiz_key,
                    'Lang' => $country->language->corbiz_key,
                    'SalesWeb' => [
                        'ttSalesWeb' => [
                            $paramsTtSalesWeb
                        ],
                    ],
                    'SalesWebItems' => [
                        'ttSalesWebItems' => $paramsTtSalesWebItems
                    ]
                ]
            ];

            $resultAddSalesWeb = $restWrapperAddSalesWeb->call('POST', $paramsAddSalesWeb, 'json', ['http_errors' => false]);

            if ($resultAddSalesWeb['success'] && $resultAddSalesWeb['responseWS']['response']['Success'] == 'true')
            {
                $this->updateOrderStatus($data, 'ORDER_COMPLETE', $resultAddSalesWeb['responseWS']['response']['Orden'], '', '', $resultAddSalesWeb['responseWS']['response']['Discount']);

                $supportEmails = Config::get('cms.email_send');
                $from_email = $supportEmails[$country->corbiz_key];

                $mail_info = [
                    'first_name'   => $data->ssa_eo_name . ' ' . $data->ssa_eo_lastname,
                    'order_number' => $resultAddSalesWeb['responseWS']['response']['Orden'],
                    'addr_name'    => $data->ssa_eo_name . ' ' . $data->ssa_eo_lastname,
                    'address'      => "{$data->ssa_address} {$data->ssa_city_name}, {$data->ssa_state}",
                    'items'        => $this->getItemsToMail($order_type->so_id),
                    'detail'       => $this->getOrderDetail($order_type->so_id),
                ];

                $to_mail    = $data->ssa_email;
                $to_name    = $data->ssa_eo_name . ' ' . $data->ssa_eo_lastname;

                if (!empty($from_email) && !empty($to_mail))
                {
                    Mail::send('shopping::frontend.shopping.includes.' . strtolower($country->corbiz_key) . '.mails.payment_success_order_corbiz', $mail_info, function ($m) use ($from_email, $to_mail, $to_name) {
                        $m->from($from_email, trans('shopping::register_customer.mail_address.title'));
                        $m->to($to_mail, $to_name)->subject(trans('shopping::checkout.confirmation.emails.order_success'));
                    });
                }

            }
            else if (!$resultAddSalesWeb['success'] && isset($resultAddSalesWeb['responseWS']['response']) && $resultAddSalesWeb['responseWS']['response']['Success'] == 'false' && isset($resultAddSalesWeb['responseWS']['response']['Error']['dsError']['ttError']))
            {
                $error_corbiz = '';
                $error_user = '';

                foreach ($resultAddSalesWeb['responseWS']['response']['Error']['dsError']['ttError'] as $i => $err)
                {
                    $error_corbiz .= $err['messTech'] . PHP_EOL;
                    $error_user .= $err['messUser'] . PHP_EOL;
                }

                $this->updateOrderStatus($data, 'CORBIZ_ERROR', 0, $error_corbiz, $error_user);

                Log::error('Request Sales addSalesWeb Cron: ' . json_encode($paramsAddSalesWeb));
                Log::error('Response Sales addSalesWeb Cron: ' . json_encode($resultAddSalesWeb));
            }
            else
            {
                $this->updateOrderStatus($data, 'CORBIZ_ERROR', 0, isset($resultAddSalesWeb['message']), isset($resultAddSalesWeb['responseWS']['_errors'][0]['_errorMsg']));

                Log::error('Request Sales addSalesWeb Cron: ' . json_encode($paramsAddSalesWeb));
                Log::error('Response Sales addSalesWeb Cron: ' . json_encode($resultAddSalesWeb));
            }
        }
        else
        {
            Log::error('Sales Cron: Sin peticiones por procesar.');
        }
    }

    /*
     * 1. Obtiene la informacion de la orden.
     */
    private function getOrderInfo($order_type)
    {
        $order = new Order();

        return $order->getOrderInfo($order_type);
    }

    private function getTtAddFormEntrepreneur($data)
    {
        $country = Country::find($data->so_country_id);
        $order_detail = OrderDetail::where([['order_id', '=', $data->so_id], ['is_kit', '=', 1]])->first();
        $warehouse = WarehouseCountry::where([['id', '=', $data->so_warehouse_id], ['country_id', '=', $country->id]])->first();

        return [
            [
                'countrysale' => $country->corbiz_key,
                'idtransaction' => !empty($data->so_corbiz_transaction) ? $data->so_corbiz_transaction : '',
                'sponsor' => !empty($data->ssa_sponsor) ? $data->ssa_sponsor : '',
                'lastnamef' => !empty($data->ssa_eo_lastnamem) ? $data->ssa_eo_lastnamem : '',
                'lastnamem' => !empty($data->ssa_eo_lastname) ? $data->ssa_eo_lastname : '',
                'names' => !empty($data->ssa_eo_name) ? $data->ssa_eo_name : '',
                'birthdate' => !empty($data->ssa_birthdate) ? $data->ssa_birthdate : '',
                'address' => !empty($data->ssa_address) ? $data->ssa_address : '',
                'number' => !empty($data->ssa_number) ? $data->ssa_number : '',
                'suburb' => !empty($data->ssa_suburb) ? $data->ssa_suburb : '',
                'complement' => !empty($data->ssa_complement) ? $data->ssa_complement : '',
                'phone' => !empty($data->ssa_telephone) ? $data->ssa_telephone : '',
                'cellphone' => !empty($data->ssa_cellphone) ? $data->ssa_cellphone : '',
                'country' => $country->corbiz_key,
                'state' => !empty($data->ssa_state) ? $data->ssa_state : '',
                'city' => !empty($data->ssa_city) ? $data->ssa_city : '',
                'county' => !empty($data->ssa_county) ? $data->ssa_county : '',
                'zipcode' => !empty($data->ssa_zip_code) ? $data->ssa_zip_code : '',
                'email' => !empty($data->ssa_email) ? $data->ssa_email : '',
                'sex' => !empty($data->ssa_gender) ? $data->ssa_gender : '',
                'idcenter' => !empty($data->so_cent_dist) ? $data->so_cent_dist : '',
                'warehouse' => $warehouse->warehouse,
                'iditem' => !empty($order_detail->countryProduct->product->sku) ? $order_detail->countryProduct->product->sku : '',
                'questions' => !empty($data->ssa_security_question_id) ? $data->ssa_security_question_id : '',
                'answer' => !empty($data->ssa_answer) ? $data->ssa_answer : '',
                'receive_adversiting' => !empty($data->so_advertise_checked) ? true : false,
                'zsource' => 'WEB',
                'zcreate' => true,
                'lang' => $country->language->corbiz_key,
                'pool' => !empty($data->ssa_is_pool) && ($data->ssa_is_pool == 1) ? true : false,
                'client_type' => ''
            ]
        ];
    }

    private function getTtAddFormDoctos($data)
    {
        $country = Country::find($data->so_country_id);
        $order_documents = OrderDocument::where([['order_id', '=', $data->so_id]])->get();
        $documents = [];

        if (count($order_documents) > 0)
        {
            foreach ($order_documents as $document)
            {
                $documents[] = [
                    'countrysale' => $country->corbiz_key,
                    'idtransaction' => !empty($data->so_corbiz_transaction) ? $data->so_corbiz_transaction : '',
                    'countrydoc' => $country->corbiz_key,
                    'iddocument' => $document->document_key,
                    'numberdoc' => $document->document_number,
                    'expirationdate' => $document->expiration_date,
                ];
            }
        }
        else
        {
            $documents[] = [
                'countrysale' => '',
                'idtransaction' => '',
                'countrydoc' => '',
                'iddocument' => '',
                'numberdoc' => '',
                'expirationdate' => '',
            ];
        }

        return $documents;
    }

    private function getTtSalesWebParams($data)
    {
        $country = Country::find($data->so_country_id);

        return [
            'countrysale' => $country->corbiz_key,
            'no_trans' => !empty($data->so_corbiz_transaction) ? $data->so_corbiz_transaction : '',
            'distributor' => !empty($data->so_distributor_number) ? $data->so_distributor_number : '',
            'amount' => !empty($data->so_total) ? $data->so_total : '',
            'receiver' => !empty($data->ssa_eo_name) ? $data->ssa_eo_name . (!empty($data->ssa_eo_lastname) ? ' ' . $data->ssa_eo_lastname : '') : '',
            'address' => !empty($data->ssa_address) ? $data->ssa_address : '',
            'number' => !empty($data->ssa_number) ? $data->ssa_number : '',
            'suburb' => !empty($data->ssa_suburb) ? $data->ssa_suburb : '',
            'complement' => !empty($data->ssa_complement) ? $data->ssa_complement : '',
            'state' => !empty($data->ssa_state) ? $data->ssa_state : '',
            'city' => !empty($data->ssa_city) ? $data->ssa_city : '',
            'county' => !empty($data->ssa_county) ? $data->ssa_county : '',
            'zipcode' => !empty($data->ssa_zip_code) ? $data->ssa_zip_code : '',
            'shippingcompany' => !empty($data->so_shipping_company) ? $data->so_shipping_company : '',
            'altAddress' => !empty($data->ssa_folio_address) && ($data->ssa_folio_address != 0) ? $data->ssa_folio_address : 0,
            'email' => !empty($data->ssa_email) ? $data->ssa_email : '',
            'phone' => !empty($data->ssa_telephone) ? $data->ssa_telephone : '',
            'previousperiod' => !empty($data->so_change_period) && ($data->so_change_period == 1) ? true : false,
            'source' => 'WEB', /* Pendiente de Validar Jose si sera con BD o archivo config */
            'type_mov'=> 'VENTA',
            'codepaid' => Config::get('shopping.paymentCorbizRelation.' . $country->corbiz_key . '.' . $data->so_bank_id),
            'zcreate' => true
        ];
    }

    private function getTtSalesWebItemsParams($data)
    {
        $country = Country::find($data->so_country_id);
        $order_details = OrderDetail::where([['order_id', '=', $data->so_id], ['active', '>=', 1]])->get();
        $items = [];

        foreach ($order_details as $key => $value)
        {
            $sku = '';

            if ($value->is_promo == 1)
            {
                if ($value->promo_prod_id > 0)
                {
                    $sku = $value->productSkuPromo->clv_producto;
                }
                else if ($value->promo_prod_id == 0)
                {
                    $sku = $value->product_code;
                }
            }
            else if ($value->is_special == 1)
            {
                $sku = $value->product_code;
            }
            else
            {
                $sku = $value->countryProduct->product->sku;
            }

            $items[] = [
                'numline' => $key + 1,
                'countrysale' => $country->corbiz_key,
                'item' => $sku,
                'quantity ' => $value->quantity,
                'listPrice' => $value->list_price,
                'discPrice' => $value->final_price,
                'points' => $value->points,
                'promo' => ($value->is_promo == 0) ? false : true,
                'kitinsc' => ($value->is_kit == 1) ? 'yes' : ''
            ];
        }

        return $items;
    }

    private function updateEo($order, $eo_number)
    {
        $update_shipping_address = [
            'eo_number' => $eo_number
        ];

        ShippingAddress::query()->where('order_id', '=', $order->so_id)->update($update_shipping_address);

        $update_order = [
            'distributor_number' => $eo_number,
            'saved_dataeo' => 1
        ];

        Order::query()->where('id', '=', $order->so_id)->update($update_order);
    }

    private function updateOrderStatus($order, $status, $corbiz_order, $error_corbiz, $error_user, $discount = null)
    {
        $order_status = $this->CommonMethods->getOrderStatusId($status, $order->so_country_id);

        $update = [
            'corbiz_order_number' => $corbiz_order,
            'order_estatus_id' => $order_status,
            'error_corbiz' => trim($error_corbiz),
            'error_user' => trim($error_user),
        ];

        if ($discount != null || $discount != '')
        {
            $update['discount'] = $discount;
        }

        Order::query()->where('id', '=', $order->so_id)->update($update);
    }

    private function generateContract($data, $countryId, $lang, $qrInfo, $countryKey)
    {
        $coords = Config::get('shopping.pdf.coords.'.$countryKey);

        $lines  = [
            ['x' => $coords[0]['x'],  'y' => $coords[0]['y'],  'content' => utf8_decode($data['name'])], # Name
            ['x' => $coords[1]['x'],  'y' => $coords[1]['y'],  'content' => utf8_decode($data['address'])], # Address
            ['x' => $coords[2]['x'],  'y' => $coords[2]['y'],  'content' => $data['city']], # City
            ['x' => $coords[3]['x'],  'y' => $coords[3]['y'],  'content' => $data['state']], # State
            ['x' => $coords[4]['x'],  'y' => $coords[4]['y'],  'content' => $data['zipCode']], # Zip code
            ['x' => $coords[5]['x'],  'y' => $coords[5]['y'],  'content' => $data['birthday']], # Birthday
            ['x' => $coords[6]['x'],  'y' => $coords[6]['y'],  'content' => $data['email']], # Email
            ['x' => $coords[7]['x'],  'y' => $coords[7]['y'],  'content' => $data['phone']], # Phone
            ['x' => $coords[8]['x'],  'y' => $coords[8]['y'],  'content' => $data['cellphone']], # Cellphone
            ['x' => $coords[9]['x'],  'y' => $coords[9]['y'],  'content' => $data['otherphone']], # Other phone
            ['x' => $coords[10]['x'], 'y' => $coords[10]['y'], 'content' => $data['dd']], # Day
            ['x' => $coords[11]['x'], 'y' => $coords[11]['y'], 'content' => $data['mm']], # Month
            ['x' => $coords[12]['x'], 'y' => $coords[12]['y'], 'content' => $data['yy']], # Year
        ];

        return generate_contract_pdf($countryId, $lang, $lines, $data['filename'], '', $qrInfo);
    }

    private function getQRContractInfo($content, $countryKey)
    {
        $qrContractConfig = Config::get('shopping.pdf.qr.'.$countryKey);

        if ($qrContractConfig['has'])
        {
            return [
                'content'   => $content,
                'img'       => [
                    'x' => $qrContractConfig['img']['x'],
                    'y' => $qrContractConfig['img']['y'],
                    'w' => $qrContractConfig['img']['w']
                ],
                'txt'       => [
                    'x' => $qrContractConfig['txt']['x'],
                    'y' => $qrContractConfig['txt']['y']
                ]
            ];
        }

        return false;
    }

    /**
     * Cron para procesar los pagos pendientes y/o con error de Paypal
     *
     */
    public function processPaypalPendingOrders() {
        $this->processPendingOrders('PAYMENT_PENDING');
        $this->processPendingOrders('CONNECTION_ERROR');
    }

    private function processPendingOrders($status) {
        $common        = new CommonMethods();
        $ordersPending = Order::getOrdersByStatus($status);

        foreach ($ordersPending as $countryKey => $orders) {
            $country       = Country::where('corbiz_key', $countryKey)->first();
            $date          = new \DateTime('now', new \DateTimeZone($country->timezone));
            $paypal        = new Paypal(strtolower($countryKey));
            $tokenResponse = $paypal->getAccessToken();

            foreach ($orders as $order) {
                $payId = $order->bank_transaction;

                if (!empty($payId)) {
                    if ($tokenResponse['success'] && isset($tokenResponse['access_token'])) {
                        $response = $paypal->getPayment($tokenResponse['access_token'], $payId);

                        if ($response['success'] && isset($response['data'])) {

                            $payTransaction = isset($response['data']->transactions[0]->related_resources[0]->sale->id) ? $response['data']->transactions[0]->related_resources[0]->sale->id : null;
                            $paymentState   = isset($response['data']->transactions[0]->related_resources[0]->sale->state) ? $response['data']->transactions[0]->related_resources[0]->sale->state : '';

                            if ($response['data']->state == 'approved' && $paymentState == 'completed') {
                                Order::where('order_number', $order->order_number)->update([
                                    'order_estatus_id'   => $common->getOrderStatusId('PAYMENT_SUCCESSFUL', $country->id),
                                    'bank_authorization' => $payTransaction,
                                    'bank_status'        => $paymentState,
                                    'updated_at'         => $date->format('Y-m-d H:i:s'),
                                ]);

                            } else if($paymentState == 'refunded') {
                                Order::where('order_number', $order->order_number)->update([
                                    'order_estatus_id'   => $common->getOrderStatusId('PAYMENT_REJECTED', $country->id),
                                    'bank_status'        => $paymentState,
                                    'updated_at'         => $date->format('Y-m-d H:i:s'),
                                ]);
                            } else {
                                Order::where('order_number', $order->order_number)->update([
                                    'order_estatus_id'   => $common->getOrderStatusId('PAYMENT_RETRY', $country->id),
                                    'bank_status'        => $response['data']->state,
                                    'updated_at'         => $date->format('Y-m-d H:i:s'),
                                ]);
                            }
                        }

                    }
                }
            }
        }

        echo "END -> {$status}<br>";
    }

    private function getItemsToMail($order) {
        $items = OrderDetail::where('order_id', $order)->get();

        foreach ($items as $i => $item) {
            if ($item->is_promo == 1) {
                $promoProduct = PromoProd::find($item->promo_prod_id);

                if (!is_null($promoProduct)){
                    $name = "{$promoProduct->clv_producto} - {$promoProduct->name}";
                    $sku = $promoProduct->clv_producto;
                } else {
                    $name = "{$item->product_code} - {$item->product_name}";
                    $sku = $item->product_code;
                }

            } else if ($item->is_special == 1) {
                $name = "{$item->product_code} - {$item->product_name}";
                $sku  = $item->product_code;
            } else {
                $countryProduct = CountryProduct::find($item->product_id);
                $name = "{$countryProduct->product->sku} - {$countryProduct->name}";
                $sku  = $countryProduct->product->sku;
            }

            $items[$i]->name = $name;
            $items[$i]->sku  = $sku;
        }

        return $items;
    }

    private function getOrderDetail($order) {
        $order = Order::find($order);

        return [
            'discount'   => $order->discount . '%',
            'subtotal'   => currency_format($order->subtotal, $order->country->currency_key),
            'points'     => $order->points,
            'management' => currency_format($order->management, $order->country->currency_key),
            'taxes'      => currency_format($order->total_taxes, $order->country->currency_key),
            'total'      => currency_format($order->total, $order->country->currency_key),
        ];
    }
}