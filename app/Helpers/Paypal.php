<?php
/**
 * Created by PhpStorm.
 * User: vicente.gutierrez
 * Date: 20/08/18
 * Time: 15:11
 */

namespace App\Helpers;

use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\Order;
use Modules\Shopping\Entities\PaymentLog;
use Modules\Shopping\Entities\PromoProd;

class Paypal {
    private $host;
    private $clientId;
    private $secret;
    private $currency;
    private $xp_profile;
    private $countryCode;

    public function __construct($country) {
        $env = strtolower(env('APP_ENV')) == 'production' ? strtolower(env('APP_ENV')) : 'development';

        $this->host        = config("paymentmethods.paypal.{$country}.{$env}.host");
        $this->clientId    = config("paymentmethods.paypal.{$country}.{$env}.client_id");
        $this->secret      = config("paymentmethods.paypal.{$country}.{$env}.secret");
        $this->currency    = config("paymentmethods.paypal.{$country}.currency");
        $this->xp_profile  = config("paymentmethods.paypal.{$country}.{$env}.xp_profile");
        $this->countryCode = config("paymentmethods.paypal.{$country}.country_code");
    }

    public function getAccessToken() {
        $result  = ['success' => false];
        $url     = "{$this->host}/v1/oauth2/token";
        $post    = 'grant_type=client_credentials';

        $response = $this->connection($url, [
            'CURLOPT_POST'           => true,
            'CURLOPT_SSL_VERIFYPEER' => false,
            'CURLOPT_USERPWD'        => "{$this->clientId}:{$this->secret}",
            'CURLOPT_HEADER'         => false,
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_POSTFIELDS'     => $post,
            'CURLOPT_VERBOSE'        => true
        ]);

        $result['success']      = $response['success'];
        $result['access_token'] = $response['data']->access_token;

        return $result;
    }

    public function createPayment($accessToken, $order) {
        $postData = $this->getJsonPayment($order);
        $url      = "{$this->host}/v1/payments/payment";

        $response = $this->connection($url, [
            'CURLOPT_POST' => true,
            'CURLOPT_SSL_VERIFYPEER' => false,
            'CURLOPT_HEADER' => false,
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_HTTPHEADER' => [
                'Authorization: Bearer '.$accessToken,
                'Accept: application/json',
                'Content-Type: application/json'
            ],
            'CURLOPT_POSTFIELDS' => $postData,
        ]);

        # Guardar en el log de pagos
        $commonMethods = new CommonMethods();
        $commonMethods->saveModelData([
            'order_id' => $order['order']->id,
            'bank_id'  => $order['order']->bank_id,
            'request'  => $postData,
            'response' => $response['success'] ? json_encode($response['data']) : json_encode($response['error']),
            'status'   => $response['success'] ? 'OK' : 'ERROR'
        ], PaymentLog::class);

        return $response;
    }

    public function processPayment($accessToken, $payerID,  $paymentID) {
        $url      = "{$this->host}/v1/payments/payment/{$paymentID}/execute";
        $postData = "{\"payer_id\" : \"{$payerID}\"}";

        $response = $this->connection($url, [
            'CURLOPT_POST' => true,
            'CURLOPT_SSL_VERIFYPEER' => false,
            'CURLOPT_HEADER' => false,
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_HTTPHEADER' => [
                'Authorization: Bearer '.$accessToken,
                'Accept: application/json',
                'Content-Type: application/json',
                # 'PayPal-Mock-Response: '.json_encode(['mock_application_codes' => 'INSTRUMENT_DECLINED']).'',
            ],
            'CURLOPT_POSTFIELDS' => $postData,
        ]);

        # Guardar en el log de pagos
        $commonMethods = new CommonMethods();
        $order         = Order::where('bank_transaction', $paymentID)->first();
        $commonMethods->saveModelData([
            'order_id' => $order->id,
            'bank_id'  => $order->bank_id,
            'request'  => $postData,
            'response' => $response['success'] ? json_encode($response['data']) : json_encode($response['error']),
            'status'   => $response['success'] ? 'OK' : 'ERROR'
        ], PaymentLog::class);

        return $response;
    }

    public function getPayment($accessToken,  $paymentID) {
        $url = "{$this->host}/v1/payments/payment/{$paymentID}";

        $response = $this->connection($url, [
            'CURLOPT_SSL_VERIFYPEER' => false,
            'CURLOPT_HEADER' => false,
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_HTTPHEADER' => [
                'Authorization: Bearer '.$accessToken,
                'Accept: application/json',
            ],
        ]);

        # Guardar en el log de pagos
        $commonMethods = new CommonMethods();
        $order         = Order::where('bank_transaction', $paymentID)->first();
        $commonMethods->saveModelData([
            'order_id' => $order->id,
            'bank_id'  => $order->bank_id,
            'request'  => '',
            'response' => $response['success'] ? json_encode($response['data']) : json_encode($response['error']),
            'status'   => $response['success'] ? 'OK' : 'ERROR'
        ], PaymentLog::class);

        return $response;
    }

    private function connection($url, $options) {
        $result = ['success' => false];
        $curl   = curl_init($url);

        if (isset($options['CURLOPT_POST'])) {
            curl_setopt($curl, CURLOPT_POST, $options['CURLOPT_POST']);
        }
        if (isset($options['CURLOPT_SSL_VERIFYPEER'])) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $options['CURLOPT_SSL_VERIFYPEER']);
        }
        if (isset($options['CURLOPT_USERPWD'])) {
            curl_setopt($curl, CURLOPT_USERPWD, $options['CURLOPT_USERPWD']);
        }
        if (isset($options['CURLOPT_HEADER'])) {
            curl_setopt($curl, CURLOPT_HEADER, $options['CURLOPT_HEADER']);
        }
        if (isset($options['CURLOPT_RETURNTRANSFER'])) {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, $options['CURLOPT_RETURNTRANSFER']);
        }
        if (isset($options['CURLOPT_POSTFIELDS'])) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $options['CURLOPT_POSTFIELDS']);
        }
        if (isset($options['CURLOPT_VERBOSE'])) {
            curl_setopt($curl, CURLOPT_VERBOSE, $options['CURLOPT_VERBOSE']);
        }
        if (isset($options['CURLOPT_HTTPHEADER'])) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $options['CURLOPT_HTTPHEADER']);
        }

        $response = curl_exec($curl);

        if (empty($response)) {
            $result['error'] = curl_error($curl);
            curl_close($curl);
        } else {
            $curlInfo = curl_getinfo($curl);
            curl_close($curl);

            if ($curlInfo['http_code'] != 200 && $curlInfo['http_code'] != 201 ) {
                $result['data']  = json_decode($response);
                $result['error'] = "Received error: {$curlInfo['http_code']}\nRaw response:{$result['data']->message}\n";
            } else {
                $result['success'] = true;
                $result['data']   = json_decode($response);
            }
        }

        return $result;
    }

    private function getJsonPayment($order) {
        $items = [];
        if (isset($order['items'])) {
            foreach ($order['items'] as $item) {

                if ($item->is_promo == 1) {
                    $promoProduct = PromoProd::find($item->promo_prod_id);

                    if (!is_null($promoProduct)){
                        $name = "{$promoProduct->clv_producto} - {$promoProduct->name}";
                        $desc = $promoProduct->description;
                    } else {
                        $name = "{$item->product_code} - {$item->product_name}";
                        $desc = '';
                    }

                } else if ($item->is_special == 1) {
                    $name = "{$item->product_code} - {$item->product_name}";
                    $desc = '';
                } else {
                    $countryProduct = CountryProduct::find($item->product_id);
                    $name = "{$countryProduct->product->sku} - {$countryProduct->name}";
                    $desc = $countryProduct->description;
                }

                $items[] = [
                    'name'        => $name,
                    'description' => $desc,
                    'quantity'    => $item->quantity,
                    'price'       => (string)$item->final_price,
                    'currency'    => $this->currency
                ];
            }
        }

        $payment = [
            'intent' => 'sale',
            'payer' => [
                'payment_method' => 'paypal'
            ],
            'transactions' => [
                [
                    'amount' => [
                        'currency' => $this->currency,
                        'total'    => (string)$order['order']->total,
                        'details'  => [
                            'subtotal'     => (string)$order['order']->subtotal,
                            'tax'          => (string)$order['order']->total_taxes,
                            'handling_fee' => (string)$order['order']->management
                        ]
                    ],
                    'description'     => 'Omnilife',
                    'custom'          => $order['order']->distributor_number,
                    'invoice_number'  => $order['order']->corbiz_transaction,
                    'payment_options' => [
                        'allowed_payment_method' => 'IMMEDIATE_PAY'
                    ],
                    'item_list' => [
                        'items' => $items,
                        'shipping_address' => [
                            'recipient_name' => $order['shipping']['eo_name'],
                            'line1'          => $order['shipping']['address'],
                            'line2'          => $order['shipping']['suburb'],
                            'city'           => $order['shipping']['city'],
                            'state'          => $order['shipping']['state'],
                            'postal_code'    => $order['shipping']['zip_code'],
                            'country_code'   => $this->countryCode,
                            'phone'          => $order['shipping']['telephone']
                        ]
                    ]
                ]
            ],
            'redirect_urls' => [
                'return_url' => route('checkout.confirmation'),
                'cancel_url' => route('checkout.confirmation')
            ]
        ];

        # $payment['experience_profile_id'] = ''; # Usar cuando sea Paypal Plus

        return json_encode($payment, JSON_UNESCAPED_SLASHES);
    }
}