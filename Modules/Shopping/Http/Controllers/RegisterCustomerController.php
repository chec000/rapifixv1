<?php

namespace Modules\Shopping\Http\Controllers;

use App\Helpers\CommonMethods;
use App\Helpers\RestWrapper;
use App\Helpers\SessionHdl;
use App\Helpers\SessionRegisterHdl;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use Modules\Admin\Entities\BrandCountry;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\Language;
use Modules\Shopping\Entities\ConfirmationBanner;
use Modules\Shopping\Entities\Customer;
use Modules\Shopping\Entities\CustomerDocument;
use Modules\Shopping\Entities\WarehouseCountry;
use View;

class RegisterCustomerController extends Controller
{
    public function __construct()
    {
        $this->CommonMethods = new CommonMethods();
    }

    /* Register Customer - Step 1 y Step 2 */
    public function index(Request $request)
    {
        /* Si el webservice o la inscripcion no esta activa y si la IP del usuario no es permitida redirigir al inicio */
        if ((config('settings::frontend.webservices') != 1 || !SessionRegisterHdl::isInscriptionActive()) && !allow_by_ip(\Request::ip()))
        {
            return redirect('/');
        }

        /* Si hay sesion iniciada redirigimos a la url de client-register con el segmento de distributor_code */
        if(!isset($request->distributor_code) && SessionHdl::hasEo())
        {
            return Redirect::route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['registercustomer']), array('distributor_code' => Session::get('portal.eo.distId')));
        }

        /* Generamos la sesion register_customer */
        $this->getGenerateSession();

        $codEo      = '';
        $numEo      = '';
        $months     = Config::get('shopping.months');
        $countries  = $this->CommonMethods->getCountries();

        /* Declaramos la variable de sesion request_businessman en false para el manejo de la url con distributor_code */
        Session::put('portal.request_businessman', false);

        /* Si la url contiene distributor_code le asiganmos valores a las variables $numEo y $codEo, y la variable de sesion request_businessman a true */
        if (count($request->all()) > 0)
        {
            $numEo  = !empty($request->distributor_code) ? $request->distributor_code : '';
            $codEo  = 1;

            Session::put('portal.request_businessman', true);
        }

        return view('shopping::frontend.customer.register', [
            'brand'         => Session::get('portal.main.brand.name'),
            'countries'     => $countries['data'],
            'months'        => $months,
            'activation'    => false,
            'codEo'         => $codEo,
            'numEo'         => $numEo,
        ]);
    }

    /* Register Customer - Validate Step 1
     * 1. Guardamos los datos en la sesion.
     * 2. Validamos los campos.
     * 3. Creamos la variable de step para activar la ventana cuando se use registro inconcluso.
     * 4. Validamos que la fecha de nacimiento sea valida. */
    public function postValidateStep1(Request $request)
    {
        $response   = [
            'success'   => false,
            'message'   => [
                'error__box_step1'  => trans('shopping::register_customer.error_rest'),
            ],
        ];

        if ($request->ajax())
        {
            Session::put('portal.register_customer.step', 1);
            Session::put('portal.register_customer.data', $request->all());

            $key_messages = array();
            $value_messages = array();
            foreach (Config::get('shopping.registercustomer.messages.' . Session::get('portal.register_customer.country_corbiz') . '.step1') as $keyMessage => $valueMessage)
            {
                $key_messages[] = $keyMessage;
                $value_messages[] = trans($valueMessage);
            }

            $key_labels = array();
            $value_labels = array();
            foreach (Config::get('shopping.registercustomer.labels.' . Session::get('portal.register_customer.country_corbiz') . '.step1') as $keyLabel => $valueLabel)
            {
                $key_labels[] = $keyLabel;
                $value_labels[] = trans($valueLabel);
            }

            $rules      = Config::get('shopping.registercustomer.rules.' . Session::get('portal.register_customer.country_corbiz') . '.step1');

            $messages   = array_combine($key_messages, $value_messages);

            $labels     = array_combine($key_labels, $value_labels);

            $validator  = Validator::make($request->all(), $rules, $messages, $labels);

            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            $bornDate = checkdate($request->month, $request->day, $request->year);

            if ($bornDate == false) {
                return response()->json([
                    'success'   => false,
                    'message'   => [
                        'borndate'  => trans('shopping::register_customer.account.borndate.alert'),
                    ],
                ]);
            }

            Session::put('portal.register_customer.step', 2);

            $response   = [
                'success'   => true,
                'message'   => '',
            ];
        }

        return $response;
    }

    /* Register Customer - Validate Step 2
     * 1. Guardamos los datos en la sesion.
     * 2. Validamos los campos. */
    public function postValidateStep2(Request $request)
    {
        $response   = [
            'success'   => false,
            'message'   => [
                'error__box_step2'  => trans('shopping::register_customer.error_rest'),
            ],
        ];

        if ($request->ajax())
        {
            Session::put('portal.register_customer.data', $request->all());

            $key_messages = array();
            $value_messages = array();
            foreach (Config::get('shopping.registercustomer.messages.' . Session::get('portal.register_customer.country_corbiz') . '.step2') as $keyMessage => $valueMessage)
            {
                $key_messages[] = $keyMessage;
                $value_messages[] = trans($valueMessage);
            }

            $key_labels = array();
            $value_labels = array();
            foreach (Config::get('shopping.registercustomer.labels.' . Session::get('portal.register_customer.country_corbiz') . '.step2') as $keyLabel => $valueLabel)
            {
                $key_labels[] = $keyLabel;
                $value_labels[] = trans($valueLabel);
            }

            $rules      = Config::get('shopping.registercustomer.rules.' . Session::get('portal.register_customer.country_corbiz') . '.step2');

            $messages   = array_combine($key_messages, $value_messages);

            $labels     = array_combine($key_labels, $value_labels);

            $validator  = Validator::make($request->all(), $rules, $messages, $labels);

            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            $response   = [
                'success'   => true,
                'message'   => '',
            ];
        }

        return $response;
    }

    /* Register Customer - Validate Step 3
     * 1. Validamos los campos. */
    public function postValidateStep3(Request $request)
    {
        $response   = [
            'success'   => false,
            'message'   => [
                'error__box_step3'  => trans('shopping::register_customer.error_rest'),
            ],
        ];

        if ($request->ajax())
        {
            $key_messages = array();
            $value_messages = array();
            foreach (Config::get('shopping.registercustomer.messages.' . Session::get('portal.register_customer.country_corbiz') . '.step3') as $keyMessage => $valueMessage)
            {
                $key_messages[] = $keyMessage;
                $value_messages[] = trans($valueMessage);
            }

            $key_labels = array();
            $value_labels = array();
            foreach (Config::get('shopping.registercustomer.labels.' . Session::get('portal.register_customer.country_corbiz') . '.step3') as $keyLabel => $valueLabel)
            {
                $key_labels[] = $keyLabel;
                $value_labels[] = trans($valueLabel);
            }

            $rules      = Config::get('shopping.registercustomer.rules.' . Session::get('portal.register_customer.country_corbiz') . '.step3');

            $messages   = array_combine($key_messages, $value_messages);

            $labels     = array_combine($key_labels, $value_labels);

            $validator  = Validator::make($request->all(), $rules, $messages, $labels);

            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            $response   = [
                'success'   => true,
                'message'   => '',
            ];
        }

        return $response;
    }

    /* Register Customer - Guardamos los datos de Step 1 y 2 en las tablas shop_customers y shop_customer_documents
     * 1. Obtenemos informacion del pais.
     * 2. Obtenemos el ID del almacen.
     * 3. Obtenemos la compañia de envio.
     * 4. Guardamos los datos de step1 y step2.
     * 5. Guardamos los datos de los documentos requeridos.
     * 6. Guardamos en la variable de sesion code el id del customer encriptada.
     * 7. Obtenemos el email de envio.
     * 8. Enviamos el correo de activacion para concluir registro de customer. */
    public function postSave(Request $request)
    {
        $response   = [
            'success'   => false,
            'message'   => trans('shopping::register_customer.error_rest'),
        ];

        if ($request->ajax())
        {
            try
            {
                $date       = new \DateTime('now', new \DateTimeZone(Session::get('portal.register_customer.time_zone')));
                $country    = Country::find(Session::get('portal.register_customer.country_id'));

                $paramsWarehouse = $this->CommonMethods->getCountryConfiguration(SessionRegisterHdl::getRouteWS(), SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCorbizLanguage());
                $warehouse  = '';

                if ($paramsWarehouse['status'])
                {
                    $isUnique   = $paramsWarehouse['WHUnique'];
                    $idWH       = isset($paramsWarehouse['idWH']) ? $paramsWarehouse['idWH'] : '';
                    $stateKey   = $paramsWarehouse['UseCity'] ? $request->state_hidden : '';
                    $cityKey    = $paramsWarehouse['UseCity'] ? $request->city_hidden : '';
                    $zip        = $paramsWarehouse['UseZipCode'] ? $request->zip : '';

                    $result_wh  = $this->CommonMethods->getAvailableWH(Session::get('portal.register_customer.webservice'), Session::get('portal.register_customer.country_corbiz'), Session::get('portal.register_customer.language_corbiz'), $stateKey, $cityKey, $zip);

                    if ($result_wh['success'] == true)
                    {
                        $warehouse  = WarehouseCountry::where(['country_id' => $country->id, 'warehouse' => $result_wh['message']['warehouse']])->first();
                    }
                    else
                    {
                        return response()->json([
                            'success'   => false,
                            'message'   => $result_wh['message'],
                        ]);
                    }
                }
                else
                {
                    return response()->json([
                        'success'   => false,
                        'message'   => trans('shopping::register_customer.error_rest'),
                    ]);
                }

                DB::beginTransaction();

                $ca = new Customer();

                $ca->country_id                 = $country->id;
                $ca->sponsor                    = strtoupper($request->distributor_code);
                $ca->sponsor_name               = $request->distributor_name;
                $ca->sponsor_email              = ($request->distributor_email == '' || $request->distributor_email == null) ? '' : $request->distributor_email;
                $ca->ca_name                    = $request->name;
                $ca->ca_lastname                = $request->lastname;
                $ca->ca_lastnamef               = $request->lastname2;
                $ca->address                    = $request->street;
                $ca->number                     = (Config::get('shopping.registercustomer.validate_form.' . $country->corbiz_key . '.number')) ? $request->ext_num : '';
                $ca->complement                 = (Config::get('shopping.registercustomer.validate_form.' . $country->corbiz_key . '.betweem_streets')) ? $request->betweem_streets : '';
                $ca->suburb                     = (Config::get('shopping.registercustomer.validate_form.' . $country->corbiz_key . '.suburb')) ? $request->colony : '';
                $ca->zip_code                   = $request->zip;
                $ca->city                       = $request->city_hidden;
                $ca->city_name                  = $request->city_name;
                $ca->state                      = $request->state_hidden;
                $ca->county                     = (Config::get('shopping.registercustomer.validate_form.' . $country->corbiz_key . '.county')) ? $request->colony : '';
                $ca->email                      = $request->email;
                $ca->telephone                  = (Config::get('shopping.registercustomer.validate_form.' . $country->corbiz_key . '.tel')) ? $request->tel : '';
                $ca->cell_number                = (Config::get('shopping.registercustomer.validate_form.' . $country->corbiz_key . '.cel')) ? $request->cel : '';
                $ca->gender                     = ($request->sex == '0') ? 'M' : 'F';
                $ca->security_question_id       = Config::get('shopping.security_question_default.' . Session::get('portal.register_customer.country_corbiz') . '.key');
                $ca->answer                     = Config::get('shopping.security_question_default.' . Session::get('portal.register_customer.country_corbiz') . '.answer');
                $ca->shipping_company           = $request->shipping_company;
                $ca->warehouse_id               = $warehouse->id;
                $ca->birthdate                  = $request->year . '-' . $request->month . '-' . $request->day;
                $ca->is_pool                    = ($request->invited == 0) ? 1 : 0;
                $ca->registration_reference_id  = ($request->invited == 0) ? $request->references : '';
                $ca->status                     = 'VALIDATION';

                if (Session::has('portal.cart.' . Session::get('portal.register_customer.country_corbiz') . '.items'))
                {
                    $ca->info_cart = json_encode(Session::get('portal.cart.' . Session::get('portal.register_customer.country_corbiz') . '.items'));
                }

                $ca->created_at                 = $date->format('Y-m-d H:i:s');
                $ca->updated_at                 = $date->format('Y-m-d H:i:s');

                $ca->save();

                if ($request->has('id_type'))
                {
                    foreach ($request->id_type as $key => $value)
                    {
                        $cad = new CustomerDocument();

                        $cad->customer_id       = $ca->id;
                        $cad->document_key      = $value;
                        $cad->document_name     = $request->id_type_name[$key];
                        $cad->document_number   = $request->id_num[$key];
                        $cad->expiration_date   = ($request->id_expiration != null || $request->id_expiration != '') ? $request->id_expiration[$key] : '';
                        $cad->created_at        = $date->format('Y-m-d H:i:s');
                        $cad->updated_at        = $date->format('Y-m-d H:i:s');

                        $cad->save();
                    }
                }

                DB::commit();

                Session::put('portal.register_customer.code', Crypt::encryptString($ca->id));

                $emailsSend = Config::get('cms.email_send');
                $emailSend  = $emailsSend[Session::get('portal.main.country_corbiz')];

                $data_customer = [
                    'view_mail'         => 'shopping::frontend.customer.mails.verify-email',
                    'from_email'        => $emailSend,
                    'title'             => trans('shopping::register_customer.mail.verify.title'),
                    'to_email'          => $request->email,
                    'name'              => !empty($request->lastname) ? $request->name . ' ' . $request->lastname : $request->name . ' ' . $request->lastname2,
                    'subject'           => trans('shopping::register_customer.mail.verify.subject'),
                    'code'              => Session::get('portal.register_customer.code'),
                ];

                $this->CommonMethods->getSendMail($data_customer);

                $response   = [
                    'success'   => true,
                    'message'   => ''
                ];
            }
            catch (Exception $e)
            {
                DB::rollBack();

                $response   = [
                    'success'   => false,
                    'message'   => $e->getMessage(),
                ];
            }
        }

        return $response;
    }

    /* Register Customer - Step 3
     * 1. Validamos si se recibe la variable code por GET.
     * 2. Desincriptamos la variable code.
     * 3. Obtenemos la informacion del customer.
     * 4. Validamos que contenga informacion y que el estatus no sea COMPLETED.
     * 5. Obtenemos listado de meses y paises.
     * 6. Guardamos los datos del customer en la variable de sesion ca.
     * 7. Actualizamos la variable step para registro inconcluso. */
    public function getActivation(Request $request)
    {
        if (!empty($request->has('code')))
        {
            $idCustomer = Crypt::decryptString($request->code);
            $ca         = Customer::find($idCustomer);

            Session::put('portal.register_customer.ca', $ca);
            Session::put('portal.register_customer.step', 3);
            Session::put('portal.register_customer.activation_option', true);
            Session::put('portal.register_customer.activation', true);
            Session::forget('portal.register_customer.data');
            Session::forget('portal.request_businessman');

            if (empty($ca) || $ca->status == 'COMPLETED')
            {
                return redirect('/')->with('modalNotificationActivationClient', true)->with('codeNotificationActivationClient', $ca->ca_number);
            }

            $this->getGenerateSession();

            $months     = Config::get('shopping.months');
            $countries  = $this->CommonMethods->getCountries();

            return view('shopping::frontend.customer.register', [
                'brand'         => Session::get('portal.main.brand.name'),
                'countries'     => $countries['data'],
                'months'        => $months,
                'activation'    => true,
                'codEo'         => '',
                'numEo'         => '',
            ]);
        }
        else
        {
            return redirect('/');
        }
    }

    /* Register Customer - Reenvio de mail de activacion
     * 1. Obtenemos el codigo e informacion del customer.
     * 2. Reenviamos el correo. */
    public function getSendMail()
    {
        $customer   = Session::get('portal.register_customer.data');
        $emailsSend = Config::get('cms.email_send');
        $emailSend  = $emailsSend[Session::get('portal.main.country_corbiz')];

        $data_customer = [
            'view_mail'         => 'shopping::frontend.customer.mails.verify-email',
            'from_email'        => $emailSend,
            'title'             => trans('shopping::register_customer.mail.verify.title'),
            'to_email'          => $customer['email'],
            'name'              => $customer['name'] . ' ' . $customer['lastname'],
            'subject'           => trans('shopping::register_customer.mail.verify.subject'),
            'code'              => Session::get('portal.register_customer.code'),
        ];

        $this->CommonMethods->getSendMail($data_customer);

        return response()->json([
            'success'   => true,
        ]);
    }

    /* Register Customer - Generar variables de sesion */
    public function getGenerateSession()
    {
        Session::put('portal.register_customer.time_zone', Session::get('portal.main.time_zone'));
        Session::put('portal.register_customer.webservice', Session::get('portal.main.webservice'));
        Session::put('portal.register_customer.country_id', Session::get('portal.main.country_id'));
        Session::put('portal.register_customer.currency_key', Session::get('portal.main.currency_key'));
        Session::put('portal.register_customer.country_corbiz', Session::get('portal.main.country_corbiz'));
        Session::put('portal.register_customer.language_id', Session::get('portal.main.language_id'));
        Session::put('portal.register_customer.language_name', Session::get('portal.main.language_name'));
        Session::put('portal.register_customer.language_corbiz', Session::get('portal.main.language_corbiz'));
    }

    /* Register Customer - Referencias de como nos conocio */
    public function postReferences(Request $request)
    {
        if ($request->ajax())
        {
            return $this->CommonMethods->getRegistrationReferences($request->country,Session::get('portal.register_customer.language_corbiz'));
        }
    }

    /* Register Customer - Obtener un empresario aleatorio */
    public function postPool(Request $request)
    {
        if ($request->ajax())
        {
            return $this->CommonMethods->getPool($request->country, 'register_customer');
        }
    }

    /* Register Customer - Obtener Shipping Company */
    public function postShippingCompanies(Request $request)
    {
        if ($request->ajax())
        {
            return $this->CommonMethods->getShippingCompaniesFromCorbiz(Session::get('portal.register_customer.webservice'), Session::get('portal.register_customer.country_corbiz'), Session::get('portal.register_customer.language_corbiz'), $request->state, $request->city);
        }
    }

    /* Register Customer - Validar Sponsor */
    public function postValidateEo(Request $request)
    {
        if ($request->ajax())
        {
            return $this->CommonMethods->validateSponsorFromCorbiz(Session::get('portal.register_customer.webservice'), Session::get('portal.register_customer.country_corbiz'), $request->sponsor, Session::get('portal.register_customer.language_corbiz'));
        }
    }

    /* Register Customer - Parametros de edad para registro */
    public function postParameters(Request $request)
    {
        if ($request->ajax())
        {
            return $this->CommonMethods->getRegistrationParameters($request->country);
        }
    }

    /* Register Customer - Obtener listado documentos requeridos */
    public function postDocuments(Request $request)
    {
        if ($request->ajax())
        {
            return $this->CommonMethods->getDocumentsFromCorbiz(Session::get('portal.register_customer.webservice'), Session::get('portal.register_customer.country_corbiz'), Session::get('portal.register_customer.language_corbiz'));
        }
    }

    /* Register Customer - Vista de datos de direccion en base al pais */
    public function postChangeView(Request $request)
    {
        try
        {
            $country = strtolower($request->country);
            $view = 'shopping::frontend.customer.includes.form_'.$country;

            if (View::exists($view))
            {
                return view($view);
            }

            return "";
        }
        catch (Exception $e)
        {
            return "";
        }
    }

    /* Register Customer - Listado de Estados */
    public function postStates(Request $request)
    {
        if ($request->ajax())
        {
            return $this->CommonMethods->getStatesFromCorbiz(Session::get('portal.register_customer.webservice'), Session::get('portal.register_customer.country_corbiz'), Session::get('portal.register_customer.language_corbiz'));
        }
    }

    /* Register Customer - Listado de Ciudades */
    public function postCities(Request $request)
    {
        if ($request->ajax())
        {
            return $this->CommonMethods->getCitiesFromCorbiz(Session::get('portal.register_customer.webservice'), Session::get('portal.register_customer.country_corbiz'), Session::get('portal.register_customer.language_corbiz'), $request->state);
        }
    }

    /* Register Customer - Obtener info de Codigo Postal */
    public function postZipCode(Request $request)
    {
        if ($request->ajax())
        {
            return $this->CommonMethods->getZipCodesFromCorbiz(Session::get('portal.register_customer.webservice'), Session::get('portal.register_customer.country_corbiz'), Session::get('portal.register_customer.language_corbiz'), $request->zipCode);
        }
    }

    /* Register Customer - Al dar clic en aceptar del modal Registro Inconcluso
     * 1. Borramos la variable de la sesion.
     * 2. Creamos la variable unfinished_register para permitir el redireccionamiento. */
    public function postExit(Request $request)
    {
        if ($request->ajax())
        {
            Session::put('portal.unfinished_register', true);

            return response()->json([
                'success'   => true,
                'message'   => url($request->url_next_exit_register),
            ]);
        }
    }

    /* Register Customer - Servicios getAvailableWH y addFormEntrepreneur
     * 1. Obtenemos el almacen.
     * 2. Creamos array de documentos.
     * 3. Validamos el customer. */
    public function postValidateCustomer(Request $request)
    {
        $response   = [
            'success'   => false,
            'message'   => [
                0   => [
                    'messUser'  => trans('shopping::register_customer.error_rest'),
                ],
            ],
            'details'   => '',
        ];

        if ($request->ajax())
        {
            $idcenter   = '';
            $warehouse  = '';
            $paramsWarehouse = $this->CommonMethods->getCountryConfiguration(SessionRegisterHdl::getRouteWS(), SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCorbizLanguage());

            if ($paramsWarehouse['status'])
            {
                $isUnique   = $paramsWarehouse['WHUnique'];
                $idWH       = isset($paramsWarehouse['idWH']) ? $paramsWarehouse['idWH'] : '';
                $stateKey   = $paramsWarehouse['UseCity'] ? $request->state_hidden : '';
                $cityKey    = $paramsWarehouse['UseCity'] ? $request->city_hidden : '';
                $zip        = $paramsWarehouse['UseZipCode'] ? $request->zip : '';

                $result_wh  = $this->CommonMethods->getAvailableWH(Session::get('portal.register_customer.webservice'), Session::get('portal.register_customer.country_corbiz'), Session::get('portal.register_customer.language_corbiz'), $stateKey, $cityKey, $zip);

                if ($result_wh['success'] == true)
                {
                    $idcenter   = $result_wh['message']['distCenter'];
                    $warehouse  = $result_wh['message']['warehouse'];
                }
                else
                {
                    return response()->json([
                        'success'   => false,
                        'message'   => $result_wh['message'],
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success'   => false,
                    'message'   => trans('shopping::register_customer.error_rest'),
                ]);
            }

            $docsCustomer   = [];

            if ($request->has('id_type'))
            {
                foreach ($request->id_type as $key => $value)
                {
                    $docsCustomer[] = [
                        'countrysale'       => Session::get('portal.register_customer.country_corbiz'),
                        'idtrasaction'      => '',
                        'countrydoc'        => Session::get('portal.register_customer.country_corbiz'),
                        'iddocument'        => $value,
                        'numberdoc'         => $request->id_num[$key],
                        'expirationdate'    => ($request->has('id_expiration')) ? $request->id_expiration[$key] : '',
                    ];
                }
            }
            else
            {
                $docsCustomer[] = [
                    'countrysale'       => '',
                    'idtrasaction'      => '',
                    'countrydoc'        => '',
                    'iddocument'        => '',
                    'numberdoc'         => '',
                    'expirationdate'    => '',
                ];
            }

            $restWrapper    = new RestWrapper(Session::get('portal.register_customer.webservice') . 'addFormEntrepreneur');
            $params         = [
                'request'   => [
                    'CountryKey'            => Session::get('portal.register_customer.country_corbiz'),
                    'Lang'                  => Session::get('portal.register_customer.language_corbiz'),
                    'AddFormEntrepreneur'   => [
                        'ttAddFormEntrepreneur' => [
                            [
                                'countrysale'           => Session::get('portal.register_customer.country_corbiz'),
                                'idtransaction'         => '',
                                'sponsor'               => $request->distributor_code,
                                'lastnamef'             => $request->lastname,
                                'lastnamem'             => $request->lastname2,
                                'names'                 => $request->name,
                                'birthdate'             => $request->year . '-' . $request->month . '-' . $request->day,
                                'address'               => $request->street,
                                'number'                => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.number')) ? $request->ext_num : '',
                                'suburb'                => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.suburb')) ? $request->colony : '',
                                'complement'            => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.betweem_streets')) ? $request->betweem_streets : '',
                                'phone'                 => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.tel')) ? $request->tel : '',
                                'cellphone'             => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.cel')) ? $request->cel : '',
                                'country'               => Session::get('portal.register_customer.country_corbiz'),
                                'state'                 => $request->state_hidden,
                                'city'                  => $request->city_hidden,
                                'county'                => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.county')) ? $request->colony : '',
                                'zipcode'               => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.zipcode')) ? $request->zip : '',
                                'shipping_company'      => $request->shipping_company,
                                'email'                 => $request->email,
                                'sex'                   => ($request->sex == 0) ? 'M' : 'F',
                                'idcenter'              => $idcenter,
                                'warehouse'             => $warehouse,
                                'iditem'                => '',
                                'questions'             => Config::get('shopping.security_question_default.' . Session::get('portal.register_customer.country_corbiz') . '.key'),
                                'answer'                => Config::get('shopping.security_question_default.' . Session::get('portal.register_customer.country_corbiz') . '.answer'),
                                'receive_adversiting'   => false,
                                'zsource'               => 'WEB',
                                'zcreate'               => false,
                                'lang'                  => Session::get('portal.register_customer.language_corbiz'),
                                'pool'                  => ($request->invited == 1) ? false : true,
                                'client_type'           => 'CFINAL',
                            ]
                        ],
                    ],
                    'AddFormDoctos'         => [
                        'ttAddFormDoctos'       => $docsCustomer
                    ],
                ]
            ];

            $result = $restWrapper->call('POST', $params, 'json', ['http_errors' => false]);

            if ($result['success'] == true && $result['responseWS']['response']['Success'] == 'true' && isset($result['responseWS']['response']['Success']))
            {
                $response = [
                    'success' => true,
                    'message' => '',
                    'details' => '',
                ];
            }
            else if ($result['success'] == false && isset($result['responseWS']['response']) && $result['responseWS']['response']['Success'] == 'false' && isset($result['responseWS']['response']['Error']['dsError']['ttError']))
            {
                $details = [];

                foreach ($result['responseWS']['response']['Error']['dsError']['ttError'] as $key => $value)
                {
                    $details[] = [
                        'err_code' => $value['idError'],
                        'err_msg' => $value['messUser'],
                        'err_tech' => $value['messTech'],
                    ];
                }

                $response = [
                    'success' => false,
                    'message' => $result['responseWS']['response']['Error']['dsError']['ttError'],
                    'details' => $details,
                ];
            }
            else
            {
                $response = [
                    'success' => false,
                    'message' => [
                        0   => [
                            'messUser'  => $result['message'],
                        ],
                        1   => [
                            'messUser'  => $result['responseWS']['_errors'][0]['_errorMsg']
                        ],
                    ],
                    'details' => [
                        [
                            'err_code' => '500',
                            'err_msg' => $result['responseWS']['_errors'][0]['_errorMsg'],
                            'err_tech' => $result['message'],
                        ]
                    ]
                ];
            }
        }

        return $response;
    }

    /* Register Customer - Servicios addFormSalesTransaction, addFormEntrepreneur y addEntrepreneur
     * 1. Obtenemos informacion del customer y pais.
     * 2. Generamos la trasaccion con el servicio addFormSalesTransaction.
     * 3. Obtenemos el almacen.
     * 4. Agregamos el customer.
     * 5. Guardamos la informacion en corbiz.
     * 6. Actualizamos los datos en BD locales. */
    public function postGenerateTransactionCustomer(Request $request)
    {
        $response   = [
            'success'   => false,
            'message'   => [
                0   => [
                    'messUser'  => trans('shopping::register_customer.error_rest'),
                ],
            ],
            'details'   => '',
        ];

        if ($request->ajax())
        {
            $status_corbiz      = false;
            $data_corbiz        = '';
            $status_transaction = false;
            $create_customer    = false;
            $transaction        = '';
            $customer           = Customer::find($request->code);
            $customer_docs      = CustomerDocument::where('customer_id', $customer->id)->get()->toArray();

            $restWrapper        = new RestWrapper(Session::get('portal.register_customer.webservice') . 'addFormSalesTransaction');
            $params             = [
                'request'       => [
                    'CountryKey'    => Session::get('portal.register_customer.country_corbiz'),
                    'Lang'          => Session::get('portal.register_customer.language_corbiz'),
                    'SalesWeb'      => [
                        'ttSalesWeb'        => [
                            [
                                'countrysale'       => Session::get('portal.register_customer.country_corbiz'),
                                'distributor'       => '',
                                'amount'            => '0.01',
                                'receiver'          => $customer->ca_name,
                                'address'           => $customer->address,
                                'number'            => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.number')) ? $customer->number : '',
                                'suburb'            => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.suburb')) ? $customer->suburb : '',
                                'complement'        => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.betweem_streets')) ? $customer->complement : '',
                                'state'             => $customer->state,
                                'city'              => $customer->city,
                                'county'            => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.county')) ? $customer->county : '',
                                'zipcode'           => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.zipcode')) ? $customer->zip_code : '',
                                'shippingcompany'   => $customer->shipping_company,
                                'altAddress'        => 0,
                                'email'             => $customer->email,
                                'phone'             => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.tel')) ? (!empty($customer->telephone) ? $customer->telephone : '') : '',
                                'cellphone'         => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.cel')) ? (!empty($customer->cell_number) ? $customer->cell_number : '') : '',
                                'previousperiod'    => false,
                                'type_mov'          => 'INGRESA',
                                'source'            => 'WEB',
                            ]
                        ]
                    ],
                    'SalesWebItems' => [
                        'ttSalesWebItems'   => []
                    ]
                ]
            ];

            $result = $restWrapper->call('POST', $params, 'json', ['http_errors' => false]);

            if ($result['success'] && $result['responseWS']['response']['Success'] == 'true' && isset($result['responseWS']['response']['Transaction']))
            {
                $status_transaction = true;
                $transaction        = $result['responseWS']['response']['Transaction'];
            }
            else if (!$result['success'] && isset($result['responseWS']['response']) && $result['responseWS']['response']['Success'] == 'false' && isset($result['responseWS']['response']['Error']['dsError']['ttError']))
            {
                $error_corbiz = '';
                $error_user = '';

                foreach ($result['responseWS']['response']['Error']['dsError']['ttError'] as $i => $err)
                {
                    $error_corbiz .= $err['messTech'] . PHP_EOL;
                    $error_user .= $err['messUser'] . PHP_EOL;
                }

                $details = [];

                foreach ($result['responseWS']['response']['Error']['dsError']['ttError'] as $key => $value)
                {
                    $details[] = [
                        'err_code' => $value['idError'],
                        'err_msg' => $value['messUser'],
                        'err_tech' => $value['messTech'],
                    ];
                }

                $this->getUpdateCustomer($customer->id, $error_corbiz, $error_user);

                return response()->json([
                    'success'   => false,
                    'message'   => $result['responseWS']['response']['Error']['dsError']['ttError'],
                    'details'   => $details,
                ]);
            }
            else
            {
                $this->getUpdateCustomer($customer->id, $result['responseWS']['_errors'][0]['_errorMsg'], $result['message']);

                return response()->json([
                    'success'   => false,
                    'message'   => [
                        0   => [
                            'messUser'  => $result['message'],
                        ],
                        1   => [
                            'messUser'  => $result['responseWS']['_errors'][0]['_errorMsg']
                        ],
                    ],
                    'details' => [
                        [
                            'err_code' => '500',
                            'err_msg' => $result['responseWS']['_errors'][0]['_errorMsg'],
                            'err_tech' => $result['message'],
                        ]
                    ]
                ]);
            }

            if ($status_transaction && isset($transaction))
            {
                $docsCustomer   = [];
                $idcenter       = '';
                $warehouse      = '';
                $paramsWarehouse = $this->CommonMethods->getCountryConfiguration(SessionRegisterHdl::getRouteWS(), SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCorbizLanguage());

                if ($paramsWarehouse['status'])
                {
                    $isUnique   = $paramsWarehouse['WHUnique'];
                    $idWH       = isset($paramsWarehouse['idWH']) ? $paramsWarehouse['idWH'] : '';
                    $stateKey   = $paramsWarehouse['UseCity'] ? $customer->state : '';
                    $cityKey    = $paramsWarehouse['UseCity'] ? $customer->city : '';
                    $zip        = $paramsWarehouse['UseZipCode'] ? $customer->zip_code : '';

                    $result_wh  = $this->CommonMethods->getAvailableWH(Session::get('portal.register_customer.webservice'), Session::get('portal.register_customer.country_corbiz'), Session::get('portal.register_customer.language_corbiz'), $stateKey, $cityKey, $zip);

                    if ($result_wh['success'] == true)
                    {
                        $idcenter   = $result_wh['message']['distCenter'];
                        $warehouse  = $result_wh['message']['warehouse'];
                    }
                    else
                    {
                        return response()->json([
                            'success'   => false,
                            'message'   => $result_wh['message'],
                        ]);
                    }
                }
                else
                {
                    return response()->json([
                        'success'   => false,
                        'message'   => trans('shopping::register_customer.error_rest'),
                    ]);
                }

                if ($customer_docs)
                {
                    foreach ($customer_docs as $doc)
                    {
                        $docsCustomer[] = [
                            'countrysale'       => Session::get('portal.register_customer.country_corbiz'),
                            'idtransaction'     => $transaction,
                            'countrydoc'        => Session::get('portal.register_customer.country_corbiz'),
                            'iddocument'        => $doc['document_key'],
                            'numberdoc'         => $doc['document_number'],
                            'expirationdate'    => $doc['expiration_date'],
                        ];
                    }
                }
                else
                {
                    $docsCustomer[] = [
                        'countrysale'       => '',
                        'idtransaction'     => '',
                        'countrydoc'        => '',
                        'iddocument'        => '',
                        'numberdoc'         => '',
                        'expirationdate'    => '',
                    ];
                }

                $restWrapperAddFormEntrepreneur = new RestWrapper(Session::get('portal.register_customer.webservice') . 'addFormEntrepreneur');
                $paramsAddFormEntrepreneur      = [
                    'request'   => [
                        'CountryKey'            => Session::get('portal.register_customer.country_corbiz'),
                        'Lang'                  => Session::get('portal.register_customer.language_corbiz'),
                        'AddFormEntrepreneur'   => [
                            'ttAddFormEntrepreneur' => [
                                [
                                    'countrysale'           => Session::get('portal.register_customer.country_corbiz'),
                                    'idtransaction'         => $transaction,
                                    'sponsor'               => $customer->sponsor,
                                    'lastnamef'             => $customer->ca_lastname,
                                    'lastnamem'             => $customer->ca_lastnamef,
                                    'names'                 => $customer->ca_name,
                                    'birthdate'             => $customer->birthdate,
                                    'address'               => $customer->address,
                                    'number'                => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.number')) ? $customer->number : '',
                                    'suburb'                => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.suburb')) ? $customer->suburb : '',
                                    'complement'            => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.betweem_streets')) ? $customer->complement : '',
                                    'phone'                 => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.tel')) ? $customer->telephone : '',
                                    'cellphone'             => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.cel')) ? $customer->cell_number : '',
                                    'country'               => Session::get('portal.register_customer.country_corbiz'),
                                    'state'                 => $customer->state,
                                    'city'                  => $customer->city,
                                    'county'                => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.county')) ? $customer->county : '',
                                    'zipcode'               => (Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.zipcode')) ? $customer->zip_code : '',
                                    'shipping_company'      => $customer->shipping_company,
                                    'email'                 => $customer->email,
                                    'sex'                   => $customer->gender,
                                    'idcenter'              => $idcenter,
                                    'warehouse'             => $warehouse,
                                    'iditem'                => '',
                                    'questions'             => $request->question,
                                    'answer'                => $request->answer,
                                    'receive_adversiting'   => false,
                                    'zsource'               => 'WEB',
                                    'zcreate'               => true,
                                    'lang'                  => Session::get('portal.register_customer.language_corbiz'),
                                    'pool'                  => ($customer->is_pool == 1) ? true : false,
                                    'client_type'           => 'CFINAL',
                                ]
                            ],
                        ],
                        'AddFormDoctos'         => [
                            'ttAddFormDoctos'       => $docsCustomer
                        ],
                    ],
                ];

                $resultAddFormEntrepreneur  = $restWrapperAddFormEntrepreneur->call('POST', $paramsAddFormEntrepreneur, 'json', ['http_errors' => false]);

                if ($resultAddFormEntrepreneur['success'] && $resultAddFormEntrepreneur['responseWS']['response']['Success'] == 'true')
                {
                    $create_customer    = true;
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

                    $details = [];

                    foreach ($resultAddFormEntrepreneur['responseWS']['response']['Error']['dsError']['ttError'] as $key => $value)
                    {
                        $details[] = [
                            'err_code' => $value['idError'],
                            'err_msg' => $value['messUser'],
                            'err_tech' => $value['messTech'],
                        ];
                    }

                    $this->getUpdateCustomer($customer->id, $error_corbiz, $error_user);

                    return response()->json([
                        'success'   => false,
                        'message'   => $resultAddFormEntrepreneur['responseWS']['response']['Error']['dsError']['ttError'],
                        'details'   => $details,
                    ]);
                }
                else
                {
                    $this->getUpdateCustomer($customer->id, $resultAddFormEntrepreneur['responseWS']['_errors'][0]['_errorMsg'], $resultAddFormEntrepreneur['message']);

                    return response()->json([
                        'success'   => false,
                        'message'   => [
                            0   => [
                                'messUser'  => $resultAddFormEntrepreneur['message'],
                            ],
                            1   => [
                                'messUser'  => $resultAddFormEntrepreneur['responseWS']['_errors'][0]['_errorMsg']
                            ],
                        ],
                        'details' => [
                            [
                                'err_code' => '500',
                                'err_msg' => $result['responseWS']['_errors'][0]['_errorMsg'],
                                'err_tech' => $result['message'],
                            ]
                        ]
                    ]);
                }
            }
            else
            {
                $this->getUpdateCustomer($customer->id, trans('shopping::register_customer.error_rest'), trans('shopping::register_customer.error_rest'));

                return response()->json([
                    'success'   => false,
                    'message'   => [
                        0   => [
                            'messUser'  => trans('shopping::register_customer.error_rest'),
                        ]
                    ],
                    'details'   => '',
                ]);
            }

            if ($create_customer)
            {
                $restWrapperAddEntrepreneur = new RestWrapper(Session::get('portal.register_customer.webservice') . 'addEntrepreneur');
                $paramsAddEntrepreneur      = [
                    'request'   => [
                        'CountryKey'        => Session::get('portal.register_customer.country_corbiz'),
                        'Lang'              => Session::get('portal.register_customer.language_corbiz'),
                        'AddEntrepreneur'   => [
                            'ttAddEntrepreneur' => [
                                [
                                    'countrySale'   => Session::get('portal.register_customer.country_corbiz'),
                                    'idTransaction' => $transaction
                                ]
                            ],
                        ]
                    ]
                ];

                $resultAddEntrepreneur  = $restWrapperAddEntrepreneur->call('POST', $paramsAddEntrepreneur, 'json', ['http_errors' => false]);

                if ($resultAddEntrepreneur['success'] && $resultAddEntrepreneur['responseWS']['response']['Success'] == 'true')
                {
                    $status_corbiz  = true;
                    $data_corbiz    = $resultAddEntrepreneur['responseWS']['response'];
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

                    $details = [];

                    foreach ($resultAddEntrepreneur['responseWS']['response']['Error']['dsError']['ttError'] as $key => $value)
                    {
                        $details[] = [
                            'err_code' => $value['idError'],
                            'err_msg' => $value['messUser'],
                            'err_tech' => $value['messTech'],
                        ];
                    }

                    $this->getUpdateCustomer($customer->id, $error_corbiz, $error_user);

                    return response()->json([
                        'success'   => false,
                        'message'   => $resultAddEntrepreneur['responseWS']['response']['Error']['dsError']['ttError'],
                        'details'   => $details,
                    ]);
                }
                else
                {
                    $this->getUpdateCustomer($customer->id, $resultAddEntrepreneur['responseWS']['_errors'][0]['_errorMsg'], $resultAddEntrepreneur['message']);

                    return response()->json([
                        'success'   => false,
                        'message'   => [
                            0   => [
                                'messUser'  => $resultAddEntrepreneur['message'],
                            ],
                            1   => [
                                'messUser'  => $resultAddEntrepreneur['responseWS']['_errors'][0]['_errorMsg'],
                            ],
                        ],
                        'details' => [
                            [
                                'err_code' => '500',
                                'err_msg' => $result['responseWS']['_errors'][0]['_errorMsg'],
                                'err_tech' => $result['message'],
                            ]
                        ]
                    ]);
                }
            }
            else
            {
                $this->getUpdateCustomer($customer->id, trans('shopping::register_customer.error_rest'), trans('shopping::register_customer.error_rest'));

                return response()->json([
                    'success'   => false,
                    'message'   => [
                        0   => [
                            'messUser'  => trans('shopping::register_customer.error_rest'),
                        ]
                    ],
                    'details'   => '',
                ]);
            }

            if ($status_corbiz && isset($data_corbiz))
            {
                try
                {
                    DB::beginTransaction();

                    $ca = Customer::find($request->code);

                    $ca->ca_number              = $data_corbiz['EntrepreneurId'];
                    $ca->password               = $data_corbiz['Password'];
                    $ca->security_question_id   = $request->question;
                    $ca->answer                 = $request->answer;
                    $ca->corbiz_transaction     = $transaction;
                    $ca->error_corbiz           = '';
                    $ca->error_user             = '';
                    $ca->status                 = 'COMPLETED';
                    $ca->save();

                    DB::commit();

                    $emailsSend = Config::get('cms.email_send');
                    $from_email = $emailsSend[Session::get('portal.main.country_corbiz')];
                    $eo         = Crypt::encryptString(Session::get('portal.main.country_corbiz') . ' ' . Session::get('portal.main.language_corbiz') .  ' ' . $data_corbiz['EntrepreneurId'] . ' ' . $data_corbiz['Password']);

                    $data_customer  = [
                        'view_mail'     => 'shopping::frontend.customer.mails.welcome-customer',
                        'from_email'    => $from_email,
                        'title'         => trans('shopping::register_customer.mail.customer.title'),
                        'to_email'      => $customer->email,
                        'name'          => $customer->ca_name . ' ' . $customer->ca_lastname,
                        'subject'       => trans('shopping::register_customer.mail.customer.subject'),
                        'code'          => $data_corbiz['EntrepreneurId'],
                        'password'      => $data_corbiz['Password'],
                        'question'      => $data_corbiz['Question'],
                        'answer'        => $request->answer,
                        'url_login'     => '/login?eo=' . $eo,
                        'url_banner'    => '/uploads/images/mailing/cresiendo/' . Session::get('portal.main.app_locale') . '/banner_kit_de_bienvenida.png'
                    ];

                    if (!empty($from_email) && !empty($customer->email))
                    {
                        $this->CommonMethods->getSendMail($data_customer);
                    }

                    $data_sponsor   = [
                        'view_mail'         => 'shopping::frontend.customer.mails.new-customer-notice-to-sponsor',
                        'from_email'        => $from_email,
                        'title'             => trans('shopping::register_customer.mail.sponsor.title'),
                        'to_email'          => $customer->sponsor_email,
                        'name'              => $customer->sponsor_name,
                        'subject'           => trans('shopping::register_customer.mail.sponsor.subject'),
                        'name_customer'     => $customer->ca_name . ' ' . $customer->ca_lastname,
                        'code_customer'     => $data_corbiz['EntrepreneurId'],
                        'tel_customer'      => $customer->telephone,
                        'email_customer'    => $customer->email
                    ];

                    if (!empty($from_email) && !empty($customer->sponsor_email))
                    {
                        $this->CommonMethods->getSendMail($data_sponsor);
                    }

                    $items = 0;

                    if (Session::has('portal.cart.' . Session::get('portal.main.country_corbiz') . '.items'))
                    {
                        $items = count(Session::get('portal.cart.' . Session::get('portal.main.country_corbiz') . '.items'));
                    }

                    $banner = ConfirmationBanner::where([
                        'country_id'    => Session::get('portal.main.country_id'),
                        'brand_id'      => Session::get('portal.main.brand.id'),
                        'purpose_id'    => 3,
                        'type_id'       => 1,
                        'active'        => 1,
                        'delete'        => 0])
                        ->first();

                    if (!$banner) {
                        $banner = ConfirmationBanner::where([
                            'country_id'    => Session::get('portal.main.country_id'),
                            'brand_id'      => 1,
                            'purpose_id'    => 3,
                            'type_id'       => 1,
                            'active'        => 1,
                            'delete'        => 0])
                            ->first();
                    }

                    $response   = [
                        'success'   => true,
                        'message'   => [
                            'url_image' => !empty($banner) ? $banner->image : '',
                            'code'      => $data_corbiz['EntrepreneurId'],
                            'password'  => $data_corbiz['Password'],
                            'question'  => $data_corbiz['Question'],
                            'country'   => Session::get('portal.register_customer.country_corbiz'),
                            'language'  => Session::get('portal.register_customer.language_corbiz'),
                            'items'     => ($items > 0) ? true : false,
                        ],
                        'details'   => '',
                    ];

                    Session::forget('portal.register_customer');
                    Session::forget('portal.request_businessman');
                    Session::forget('portal.unfinished_register');
                }
                catch (Exception $e)
                {
                    DB::rollBack();

                    $this->getUpdateCustomer($customer->id, $e->getMessage(), $e->getMessage());

                    $response   = [
                        'success'   => false,
                        'message'   => [
                            'error__box_ul_step3'   => $e->getMessage(),
                        ],
                        'details'   => '',
                    ];
                }
            }
            else {
                $this->getUpdateCustomer($customer->id, trans('shopping::register_customer.error_rest'), trans('shopping::register_customer.error_rest'));

                return response()->json([
                    'success'   => false,
                    'message'   => [
                        0   => [
                            'messUser'  => trans('shopping::register_customer.error_rest'),
                        ]
                    ],
                    'details'   => '',
                ]);
            }
        }

        return $response;
    }

    private function getUpdateCustomer($id_customer, $error_corbiz, $error_user)
    {
        $date = new \DateTime('now', new \DateTimeZone(Session::get('portal.register_customer.time_zone')));

        $update = [
            'error_corbiz'  => $error_corbiz,
            'error_user'    => $error_user,
            'updated_at'    => $date->format('Y-m-d H:i:s'),
        ];

        Customer::query()->where('id', '=', $id_customer)->update($update);
    }

    public function backStep2(Request $request)
    {
        if ($request->ajax()) {
            Session::put('portal.register_customer.step', 1);

            return [
                'status'    => true,
                'data'      => [],
                'messages'  => []
            ];
        }
    }

    public function validateStreet(Request $request)
    {
        $response = [
            'passes'    => false,
            'message'   => trans('shopping::register.info.address.street_message')
        ];

        if ($request->ajax() && !empty($request->street))
        {
            $hasRestricteds = str_contains(strtoupper($request->street),config('shopping.validation_po_box'));

            if ($hasRestricteds)
            {
                $response = [
                    'passes'    => false,
                    'message'   => trans('shopping::register.info.address.street_message_fail')
                ];
            }
            else
            {
                $response = [
                    'passes'    => true,
                    'message'   => trans('shopping::register.info.address.street_message')
                ];
            }
        }

        return $response;
    }
}