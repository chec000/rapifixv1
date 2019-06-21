<?php
/**
 * Created by PhpStorm.
 * User: vicente.gutierrez
 * Date: 10/08/18
 * Time: 11:56
 */

namespace Modules\Shopping\Http\Controllers\traits;


use App\Helpers\CommonMethods;
use App\Helpers\SessionHdl;
use App\Helpers\SessionRegisterHdl;
use App\Helpers\ShoppingCart;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Modules\Admin\Entities\Language;
use Modules\Shopping\Entities\ConfirmationBanner;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\Order;
use Modules\Shopping\Entities\OrderDetail;
use Modules\Shopping\Entities\OrderDocument;
use Modules\Shopping\Entities\Product;
use Modules\Shopping\Entities\PromoProd;
use Modules\Shopping\Entities\ShippingAddress;
use Modules\Shopping\Entities\Source;
use Modules\Shopping\Entities\WarehouseCountry;

trait Register {

    // Metodos antes del pago
    /**
     * getWSFormEntepreneur
     * Regresa un arreglo con la información nesesaría del proceso de inscripcion para el parámetro ['request']['AddFormEntrepreneur']['ttAddFormEntrepreneur']
     * que se envía en la petición del servicio web addFormSalesTransaction
     *   Para validar se deben enviar los siguientes campos con estos valores:
    ttAddFormEntrepreneur
        idtransaction = '' debe enviarse vacio
        iditem =  '9410322' kit seleccionado por el usuario
        zcreate = false * IMPORTANTE * si se valida va en false
        client_type = '' para empresario
     *
     * @bool gereateOrder utilizado para verificar si los datos son para la validación del formulario o almacenar los datos en corboz
     * @bool isConfirmation utilizado para validar si se tomaran los datos de la sesion o de la DB false para sesión true para DB
     * @array orderData Arreglo con los datos retornados por el controlador del método de pago
     * @return array
     */
    private function getWSFormEntepreneur($generateOrder = false,$isConfirmation = false,$orderData = array()) {
        $formEntepreneur = [];

        if($isConfirmation){

            $order = $orderData['order'];
            $orderDetail = $orderData['orderDetail'];
            $shippingAddress = $orderData['shippingAddress'];
            $lanDefault = Language::where('locale_key', '=', $order->country->default_locale)->first();
            $warehouse = WarehouseCountry::where('id',$order['warehouse_id'])->first();

            $kit = $this->obtainSkuKit($order['id']);



            $formEntepreneur = [
                            'countrysale' => isset($order->country->corbiz_key) ? $order->country->corbiz_key : '',
                            'idtransaction' => isset($order['corbiz_transaction']) ? $order['corbiz_transaction'] : '',
                            'sponsor' => isset($shippingAddress['sponsor']) ? $shippingAddress['sponsor'] : '',
                            'lastnamef' => isset($shippingAddress['eo_lastname']) ? $shippingAddress['eo_lastname'] : '',
                            'lastnamem' => isset($shippingAddress['eo_lastnamem']) ? $shippingAddress['eo_lastnamem'] :'',
                            'names' => isset($shippingAddress['eo_name']) ? $shippingAddress['eo_name'] : '',
                            'birthdate' => isset($shippingAddress['birthdate']) ? $shippingAddress['birthdate'] : '',
                            'address' => isset($shippingAddress['address']) ? $shippingAddress['address'] : '',
                            'number' => isset($shippingAddress['number']) ? $shippingAddress['number'] : '',
                            'suburb' => isset($shippingAddress['suburb']) ? $shippingAddress['suburb'] : '',
                            'complement' => isset($shippingAddress['complement']) ? $shippingAddress['complement'] : '',
                            'phone' => isset($shippingAddress['telephone']) ? $shippingAddress['telephone'] : '',
                            'cellphone' => isset($shippingAddress['cellphone']) ? $shippingAddress['cellphone'] : '',
                            'country' => isset($order->country->corbiz_key) ? $order->country->corbiz_key : '',
                            'state' => isset($shippingAddress['state']) ? $shippingAddress['state'] : '',
                            'city' => isset($shippingAddress['city']) ? $shippingAddress['city'] : '',
                            'county' => isset($shippingAddress['suburb']) ? $shippingAddress['suburb'] : '',
                            'shipping_company' => isset($order['shipping_company']) ? $order['shipping_company'] : '',
                            'zipcode' => isset($shippingAddress['zip_code']) ? $shippingAddress['zip_code'] : '',
                            'email' => isset($shippingAddress['email']) ? $shippingAddress['email'] : '',
                            'sex' => isset($shippingAddress['gender']) ? $shippingAddress['gender'] : '',
                            'idcenter' => isset($order['cent_dist']) ? $order['cent_dist'] : '',
                            'warehouse' => isset($warehouse) ? $warehouse->warehouse : '',
                            'iditem' => isset($kit['sku']) ? $kit['sku'] : '',
                            'questions' => isset($shippingAddress['security_question_id']) ? $shippingAddress['security_question_id'] : '',
                            'answer' => isset($shippingAddress['answer']) ? $shippingAddress['answer'] : '',
                            'receive_adversiting' => isset($order['advertise_checked']) ? true : false,
                            'zsource' => 'WEB',
                            'zcreate' => $generateOrder,
                            'lang' => $lanDefault->corbiz_key,
                            'pool' => isset($shippingAddress['is_pool']) == 1 ? true : false,
                            'client_type' => ''
             ];
        }
        else{
            if (SessionRegisterHdl::hasSteps()) {
                $steps = SessionRegisterHdl::getSteps();


                $formEntepreneur = [
                    'countrysale' => SessionRegisterHdl::getCorbizCountryKey(),
                    'idtransaction' => SessionRegisterHdl::hasTransaction() ? SessionRegisterHdl::getTransaction() : '',
                    'sponsor' => $steps['invited'] == "1" ? $steps['register-code'] : $steps['distributor_code'],
                    'lastnamef' => $steps['lastname'],
                    'lastnamem' => $steps['lastname2'],
                    'names' => $steps['name'],
                    'birthdate' => $steps['year']."-".$steps['month']."-".$steps['day'],//'1990-08-28',
                    'address' => $steps['street'],
                    'number' => isset($steps['ext_num']) ? $steps['ext_num'] : '',
                    'suburb' => $steps['colony'],
                    'complement' => $steps['betweem_streets'],
                    'phone' => $steps['tel'],
                    'cellphone' => $steps['cel'],
                    'country' => SessionRegisterHdl::getCorbizCountryKey(),
                    'state' => $steps['state_hidden'],
                    'city' => $steps['city_hidden'],
                    'county' => $steps['colony'],
                    'shipping_company' => config('shopping.defaultValidationForm.'.SessionRegisterHdl::getCorbizCountryKey().'.shipping_way'),//Default del pais
                    'zipcode' => $steps['zip'],
                    'email' => $steps['email'],
                    'sex' => $steps['sex'],
                    'idcenter' =>  isset($steps['distCenter']) ? $steps['distCenter'] : config('shopping.defaultValidationForm.' . SessionRegisterHdl::getCorbizCountryKey() . '.idcenter'),
                    'warehouse' => isset($steps['warehouse']) ? $steps['warehouse']   : config('shopping.defaultValidationForm.' . SessionRegisterHdl::getCorbizCountryKey() . '.warehouse'),
                    'iditem' =>    isset($steps['kitselected']) ? $steps['kitselected'] : config('shopping.defaultValidationForm.' . SessionRegisterHdl::getCorbizCountryKey() . '.kit'),//Kit fijo para validar el formulario,
                    'questions' => $steps['secret-question'],
                    'answer' => $steps['response-question'],
                    'receive_adversiting' => isset($steps['terms3']) == 'on' ? true : false,
                    'zsource' => 'WEB',
                    'zcreate' => $generateOrder,
                    'lang' => SessionRegisterHdl::getCorbizLanguage(),
                    'pool' => $steps['invited'] == '0' ? true : false,
                    'client_type' => ''
                ];
            }
        }


        return $formEntepreneur;
    }

    private function obtainSkuKit($orderid){
        $kitinfo = [];
        $kits = OrderDetail::where(['order_id' => $orderid,'is_kit' => 1])->first();
        $countryProduct = $kits->countryProduct;


        if(!is_null($countryProduct)){
            $kitinfo = ['sku' => $countryProduct->product->sku,'listPrice' => $countryProduct['price']];
        }

        return $kitinfo;

    }


    private function obtainProductInfo($orderid,$productid){
        $productInfo = [];
        $prods = OrderDetail::where(['order_id' => $orderid])->first();

        if ($prods->is_promo == 1) {
            $promoProduct = PromoProd::find($prods->promo_prod_id);

            if (!is_null($promoProduct)){
                $sku = $promoProduct->clv_producto;
                $listPrice = 0;
            } else {
                $sku = $prods->product_code;
                $listPrice = 0;
            }

        } else if ($prods->is_special == 1) {
            $sku  = $prods->product_code;
            $listPrice = 0;

        } else {
            $countryProduct = CountryProduct::find($prods->product_id);
            $sku  = $countryProduct->product->sku;
            $listPrice = $countryProduct->price;
        }





        $productInfo = ['sku' => $sku,'listPrice' => $listPrice];


        return $productInfo;

    }

    /**
     * getWSDocsEntepreneur
     * Regresa un arreglo con los documentos ingresados por el usuario ['request']['AddFormEntrepreneur']['ttAddFormDoctos']
     * que se envía en la petición del servicio web addFormSalesTransaction
     *
     *
     * @return array
     */
    private function getWSDocsEntepreneur($action = '',$orderId = '',$transaction = '',$country = '') {


        //regresa el formato de los documentos para insertarlo en la tabla shop_orders_documents
        if($action == 'insert'){
            $docsEntepreneur = [];
            if (SessionRegisterHdl::hasSteps()) {
                $steps = SessionRegisterHdl::getSteps();
                if(!empty($steps['id_type'])){
                    foreach ($steps['id_type'] as $key => $dt){

                        $docsEntepreneur[] = ['order_id' => $orderId,'document_key' => $dt,'document_name' => $steps['id_type_name'][$key],'document_number' => $steps['id_num'][$key],'document_expiration' => $steps['id_expiration'][$key]];

                    }
                }else{

                        $docsEntepreneur[] = ['order_id' => '','document_name' => '','document_number' => '','document_expiration' => ''];

                }

            }
        }
        //Documentos obtenidos de la base de datos
        else if($action == 'obtain'){

            $docsEntepreneur = [];
            $documents = OrderDocument::where('order_id',$orderId)->get();

            if($documents->count() > 0){


                foreach ($documents as $doc){

                    $docsEntepreneur[] = ['countrysale' => $country,'idtransaction' => $transaction,'countrydoc' => $country,'iddocument' =>$doc['document_key'],'numberdoc' => $doc['document_number'],'expirationdate' => $doc['document_expiration']];

                }
            }else{


                $docsEntepreneur[] = ['countrysale' => '','idtransaction' => '','countrydoc' => '','iddocument' =>'','numberdoc' => '','expirationdate' => ''];

            }





        }
        //Documentos para webservice
        else{
            $docsEntepreneur = [];
            if (SessionRegisterHdl::hasSteps()) {
                $steps = SessionRegisterHdl::getSteps();
                if(!empty($steps['id_type'])){
                    foreach ($steps['id_type'] as $key => $dt){

                        $docsEntepreneur[] = ['countrysale' => SessionRegisterHdl::getCorbizCountryKey(),'idtransaction' => SessionRegisterHdl::getTransaction(),'countrydoc' => SessionRegisterHdl::getCorbizCountryKey(),'iddocument' => $dt,'numberdoc' => $steps['id_num'][$key],'expirationdate' => $steps['id_expiration'][$key]];

                    }
                }else{

                    $docsEntepreneur[] = ['countrysale' => '','idtransaction' => '','countrydoc' => '','iddocument' =>'','numberdoc' => '','expirationdate' => ''];

                }

            }
        }




        return $docsEntepreneur;
    }


    /**
     * getWSSalesWeb
     * Regresa un arreglo con la información nesesaría del proceso de compra para el parámetro ['request']['SalesWeb']['ttSalesWeb']
     * que se envía en la petición del servicio web addFormSalesTransaction
     *
     * TODO Agregar a los campos 'amount' y 'previousperiod' la información real faltante de la cotización
     *
     * @return array
     */
    private function getWSSalesWeb($generateOrder = false,$isConfirmation = false,$orderData = array(),$eonumber = '') {

        $salesWeb = [];
        if($isConfirmation){
            $order = $orderData['order'];
            $orderDetail = $orderData['orderDetail'];
            $shippingAddress = $orderData['shippingAddress'];
            $paymentCodes = config("shopping.paymentCorbizRelation.".$order->country->corbiz_key);

            $salesWeb = [
                'countrysale'     => isset($order->country->corbiz_key) ? $order->country->corbiz_key : '',
                'no_trans'        => isset($order['corbiz_transaction']) ? $order['corbiz_transaction'] : '',//Default para validar el fomulario,
                'distributor'     => $eonumber,//'',
                'amount'          => isset($order['total']) ? $order['total'] : '',
                'receiver'        => $shippingAddress['eo_name'].' '.$shippingAddress['eo_lastname'],
                'address'         => isset($shippingAddress['address']) ? $shippingAddress['address'] : '',
                'number'          => isset($shippingAddress['number']) ? $shippingAddress['number'] : '',
                'suburb'          => isset($shippingAddress['suburb']) ? $shippingAddress['suburb'] : '',
                'complement'      => isset($shippingAddress['complement']) ? $shippingAddress['complement'] : '',
                'state'           => isset($shippingAddress['state']) ? $shippingAddress['state'] : '',
                'city'            => isset($shippingAddress['city']) ? $shippingAddress['city'] : '',
                'county'          => isset($shippingAddress['county']) ? $shippingAddress['county'] : '',
                'zipcode'         => isset($shippingAddress['zip_code']) ? $shippingAddress['zip_code'] : '',
                'shippingcompany' => isset($order['shipping_company']) ? $order['shipping_company'] : '',//Default para validar el fomulario,
                'altAddress'      => 0,
                'email'           => isset($shippingAddress['email']) ? $shippingAddress['email'] : '',
                'phone'           => isset($shippingAddress['telephone']) ? $shippingAddress['telephone'] : '',
                'cellphone'           => isset($shippingAddress['cellphone']) ? $shippingAddress['cellphone'] : '',
                'previousperiod' => false,
                'source'         => 'WEB',
                'type_mov'=> 'INGRESA',
                'codepaid' => $paymentCodes[$order['bank_id']],
                'zcreate' => $generateOrder,
            ];


        }else{
            if (SessionRegisterHdl::hasSteps()) {

                $steps = SessionRegisterHdl::getSteps();
                $quotation = SessionRegisterHdl::getRegisterQuotation();
                $salesWeb = [
                    'countrysale'     => SessionRegisterHdl::getCorbizCountryKey(),
                    'distributor'     => '',
                    'amount'          => isset($quotation['total']) ? $quotation['total'] : 1,
                    'receiver'        => $steps['name'],
                    'address'         => $steps['street'],
                    'number'          => isset($steps['ext_num']) ? $steps['ext_num'] : '',
                    'suburb'          => $steps['colony'],
                    'complement'      => $steps['betweem_streets'],
                    'state'           => $steps['state_hidden'],
                    'city'            => $steps['city_hidden'],
                    'county'          => $steps['colony'],
                    'zipcode'         => $steps['zip'],
                    'shippingcompany' => isset($steps['shipping_way']) ? $steps['shipping_way'] : '',//Default para validar el fomulario,
                    'altAddress'      => 0,
                    'email'           => $steps['email'],
                    'phone'             => (Config::get('shopping.register.validate_form.' . Session::get('portal.register.country_corbiz') . '.tel')) ? (!empty($steps['tel']) ? $steps['tel'] : '') : '',
                    'cellphone'         => (Config::get('shopping.register.validate_form.' . Session::get('portal.register.country_corbiz') . '.cel')) ? (!empty($steps['cel']) ? $steps['cel'] : '') : '',
                    'previousperiod' => false,
                    'type_mov'=> 'INGRESA',
                    'source' => 'WEB'
                ];

                if ($generateOrder) {
                    $paymentCodes = config("shopping.paymentCorbizRelation.".SessionRegisterHdl::getCorbizCountryKey());
                    $salesWeb['no_trans'] = SessionRegisterHdl::getTransaction();
                    $salesWeb['type_mov'] = 'INGRESA';
                    $salesWeb['codepaid'] = $paymentCodes[SessionRegisterHdl::getPaymentMethod()];
                    $salesWeb['zcreate']  = true;
                }
            }
        }



        return $salesWeb;
    }

    /**
     * getWSSalesWebItems
     * Regresa un arreglo con la información nesesaría del proceso de compra para el parámetro ['request']['SalesWebItems']['ttSalesWebItems']
     * que se envía en la petición del servicio web addFormSalesTransaction
     *
     * TODO Usar la información real de la cotización
     *
     * @return array
     */
    private function getWSSalesWebItems($isConfirmation = false,$orderInfo = array()) {

        $salesWebItems = [];
        if($isConfirmation){

            $order = $orderInfo['order'];
            $orderDetail = $orderInfo['orderDetail'];


            foreach ($orderDetail as $key => $value)
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

                $salesWebItems[] = [
                    'numline' => $key + 1,
                    'countrysale' => $order->country->corbiz_key,
                    'item' => $sku,
                    'quantity ' => $value->quantity,
                    'listPrice' => $value->list_price,
                    'discPrice' => $value->final_price,
                    'points' => $value->points,
                    'promo' => ($value->is_promo == 0) ? false : true,
                    'kitinsc' => ($value->is_kit == 1) ? 'yes' : ''
                ];
            }



        }else{
            $quotation     = SessionRegisterHdl::getRegisterQuotation();

            foreach ($quotation['items'] as $i => $item) {
                $salesWebItems[] = [
                    'numline'     => $i+1,
                    'countrysale' => SessionRegisterHdl::getCorbizCountryKey(),
                    'item'        => $item['sku'],
                    'quantity '   => $item['quantity'],
                    'listPrice'   => $item['listPrice'],
                    'discPrice'   => $item['discPrice'],
                    'points'      => $item['points'],
                    'promo'       => $item['promo']
                ];
            }
        }


        return $salesWebItems;
    }

/**
     * saveInscriptionOrder
     * Guarda la información de una orden en las tablas shop_orders y shop_orders_detail
     *
     * @return array
     */
    private function saveInscriptionOrder() {
        $response = ['status' => false];
        $isSaved  = false;



            DB::transaction(function () use (&$isSaved, &$response) {


                try {
                    $order = $this->CommonMethods->saveModelData($this->getOrderDataFromQuotation(), Order::class);

                    if ($order !== false) {
                        //Almacenamiento de documentos en caso de haberlos
                        $documents = $this->getWSDocsEntepreneur('insert',$order->id);

                        foreach ($documents as $doc) {
                            $this->CommonMethods->saveModelData($doc, OrderDocument::class);
                        }
                        $items = $this->getOrderDetailDataFromQuotation($order->id);
                        foreach ($items as $item) {
                            $this->CommonMethods->saveModelData($item, OrderDetail::class);
                        }
                        $this->CommonMethods->saveModelData($this->getOrderShippingAddressFromQuotation($order->id), ShippingAddress::class);

                        $isSaved = true;
                        $response['status'] = true;

                    } else {
                        $response['status'] = false;
                        $response['errors'] = [trans('shopping::checkout.payment.errors.sys003')];
                        Log::error('ERR (SYS003): Problema al guardar en la tabla shop_orders');
                    }
                } catch (QueryException $e) {
                    if ($e->errorInfo[1] != 1062) {
                        # Error
                        $isSaved = true;
                    } else {
                        $response['status'] = false;
                        $response['errors'] = [trans('shopping::checkout.payment.errors.sys001')];
                        Log::error('ERR (SYS001): ' . $e->getMessage());
                    }

                    # Si código de error de MySQL es 1062 seguimos iterando con el while hasta que se pueda insertar con
                    # un número de order correcto o se genere otro error
                } catch (\Exception $e) {
                    $response['status'] = false;
                    $response['errors'] = [$e->getMessage()];
                    Log::error('ERR (SYS002): ' . $e->getMessage());
                }
            });


        return $response;
    }

    /**
     * getOrderDataFromQuotation
     * Regresa un arreglo con la información necesaria del proceso de compra para guardar en la tabla de shop_orders
     *
     * TODO Obtener el campo 'corbiz_payment_key''
     * TODO Preguntar flujo si getOrderStatusId regresa null
     *
     * @param array $aditionalData  Campos adicionales para insertar
     * @return array
     */
    private function getOrderDataFromQuotation($aditionalData = []) {
        $common    = new CommonMethods();
        $quotation = $this->getQuotation();
        $salesWeb  = $this->getWSSalesWeb();
        $steps = SessionRegisterHdl::getSteps();
        $source    = Source::where('source_name', 'web')->first();
        $date      = new \DateTime('now', new \DateTimeZone(SessionHdl::getTimeZone()));
        $order = [
            'country_id'          => SessionRegisterHdl::getCountryID(),
            'distributor_number'  => '',
            'order_estatus_id'    => $common->getOrderStatusId('NEW_ORDER', SessionRegisterHdl::getCountryID()),
            'order_number'        => $common->getNextOrderNumber(SessionRegisterHdl::getCountryID()), //'1200000002'
            'points'              => $quotation['points'],
            'total_taxes'         => $quotation['taxes'],
            'total'               => $quotation['total'],
            'subtotal'            => $quotation['subtotal'],
            'discount'            => '',
            'shipping_company'    => $salesWeb['shippingcompany'],
            'guide_number'        => '',
            'corbiz_order_number' => '0',
            'bank_id'             => SessionRegisterHdl::getPaymentMethod(),
            'shop_type'           => 'INSCRIPTION',
            'corbiz_transaction'  => SessionRegisterHdl::getTransaction(),
            'warehouse_id'        => $common->getWarehouseId(SessionRegisterHdl::getCountryID(),$steps['warehouse']),
            'cent_dist'           => $steps['distCenter'],
            'management'          => $quotation['handling'],
            'attempts'            => 0,
            'change_period'       => $quotation['period_change'],
            'source_id'           => $source->id,
            'terms_checked'       => Session::get('portal.register.hour_terms1'),
            'policies_checked'    => Session::get('portal.register.hour_terms2'),
            'advertise_checked'   => Session::get('portal.register.hour_terms3'),
            'last_modifier_id'     => 1,
            'created_at'          => $date->format('Y-m-d H:i:s'),
            'updated_at'          => $date->format('Y-m-d H:i:s'),
        ];

        $order = array_merge($order, $aditionalData);


        return $order;
    }

    /**
     * getOrderDetailDataFromQuotation
     * Regresa un arreglo con la información necesaria por cada item del proceso de compra para guardar en la tabla
     * shop_orders_detail
     *
     * TODO Usar la información real de los productos
     *
     * @return array
     */
    private function getOrderDetailDataFromQuotation($orderId) {
        $quotation   = SessionRegisterHdl::getRegisterQuotation();
        $date        = new \DateTime('now', new \DateTimeZone(SessionRegisterHdl::getTimeZone()));
        $orderDetail = [];

        foreach ($quotation['items'] as $i => $item) {


            $productCode = '';
            $productName = '';

            if ($item['is_special']) {
                $productCode = $item['sku'];
                $productName = $item['name'];
            } else if ($item['promo']) {
                if ($item['id'] == 0 || empty($item['id'])) {
                    $productCode = $item['sku'];
                    $productName = $item['name'];
                }
            }

            $orderDetail[] = [
                'order_id'           => $orderId,
                'product_id'         => $item['id'],
                'promo_prod_id'      => $item['promo'] ? $item['id'] : 0,
                'quantity'           => $item['quantity'],
                'list_price'         => $item['listPrice'], # listPrice
                'final_price'        => $item['discPrice'],
                'points'             => $item['points'],
                'is_kit'             => $item['iskit'],
                'active'             => 1,
                'is_promo'           => $item['promo'] == true ? 1 : 0,
                'tax_percentage'     => '',
                'tax_currency'       => '',
                'tax_amount'         => $item['tot_tax'],
                'tax_unit'           => $item['unit_tax'], # tot_tax
                'is_special'         => $item['is_special'] ? 1 : 0,
                'product_code'       => $productCode,
                'product_name'       => $productName,
                'last_modifier_id'   => 1,
                'created_at'         => $date->format('Y-m-d H:i:s'),
                'updated_at'         => $date->format('Y-m-d H:i:s'),
            ];
        }

        return $orderDetail;
    }


    private function getOrderShippingAddressFromQuotation($orderId) {
        $steps = SessionRegisterHdl::getSteps();
        $date      = new \DateTime('now', new \DateTimeZone(SessionHdl::getTimeZone()));

        $orderShipping = [
            'order_id'             => $orderId,
            'sponsor'              => $steps['distributor_code'],
            'sponsor_name'         => $steps['distributor_name'],
            'sponsor_email'        => $steps['distributor_email'],
            'eo_number'            => '', # OBLIGATORIO
            'eo_name'              => $steps['name'],
            'eo_lastname'          => $steps['lastname'],
            'eo_lastnamem'         => $steps['lastname2'],
            'type_address'         => 'PERSONAL', # OBLIGATORIO
            'folio_address'        => 0, # OBLIGATORIO
            'address'              => $steps['street'], # OBLIGATORIO
            'number'               => isset($steps['ext_num']) ? $steps['ext_num'] : '', # OBLIGATORIO
            'complement'           => $steps['betweem_streets'],
            'suburb'               => $steps['colony'], # OBLIGATORIO
            'zip_code'             => $steps['zip'], # OBLIGATORIO
            'city'                 => $steps['city_hidden'], # OBLIGATORIO
            'city_name'            => $steps['city_name'], # OBLIGATORIO
            'state'                => $steps['state_hidden'], # OBLIGATORIO
            'county'               => $steps['colony'], # OBLIGATORIO
            'email'                => $steps['email'], # OBLIGATORIO
            'telephone'            => $steps['tel'], # OBLIGATORIO
            'cellphone'            => $steps['cel'],
            'gender'               => $steps['sex'],
            'registration_reference_id' => isset($steps['references']) ? $steps['references'] : '',
            'security_question_id' => $steps['secret-question'],
            'answer'               => $steps['response-question'],
            'kit_type'             => '',
            'order_document_id'    => '',
            'birthdate'            => $steps['year']."-".$steps['month']."-".$steps['day'],
            'is_pool'              => $steps['ispool'],
            'public_ip'            => \Request::getClientIp(true),
            'last_modifier_id'     => 1,
            'created_at'          => $date->format('Y-m-d H:i:s'),
            'updated_at'          => $date->format('Y-m-d H:i:s'),
        ];

        if (isset($steps['cpf'])) {
            $orderShipping['cpf'] = $steps['cpf'];
        }

        return $orderShipping;
    }

    /**
     * getQuotation
     * Regresa la cotización de la venta de la sesión
     *
     * TODO Extraer la información real de la cotización de la sesión
     *
     * @return array
     */
    private function getQuotation() {
        $quotation = [];
        if (SessionRegisterHdl::hasRegisterQuotation()) {
            $quotation = SessionRegisterHdl::getRegisterQuotation();
        }

        return $quotation;
    }


    /**
     * getBanners
     * Obtiene los ConfirmationBanners que se deben mostrar
     *
     * @param $type             Tipo del banner
     * @param $purpose          Propósito del banner
     * @param $countryID        ID del país
     * @return mixed
     */
    private function getBanners($type, $purpose, $countryID,$brandID) {

        $banners = ConfirmationBanner::whereHas('type', function ($q) use ($type) {
            $q->where('type', $type);
        })->whereHas('purpose', function ($q) use ($purpose) {
            $q->where('purpose', $purpose);
        })->where('country_id', $countryID)->where('brand_id', $brandID)->where('active', 1)->where('delete', 0)->get();

        if (!$banners) {
            $banners = ConfirmationBanner::where([
                'country_id'    => Session::get('portal.main.country_id'),
                'brand_id'      => 1,
                'purpose_id'    => 3,
                'type_id'       => 1,
                'active'        => 1,
                'delete'        => 0])
                ->first();
        }

        return $banners;
    }


    public static function setSessionCartAddSalesWeb($arrayData){

        $items = array();

        //Prearmado de la cotizacion para guardar en session
        $sessionCheckout = [
            'subtotal' => $arrayData['Subtotal'],
            'discount' => $arrayData['Discount'],
            'handling' => $arrayData['Handling'],
            'taxes' => $arrayData['Taxes'],
            'total' => $arrayData['Total'],
            'points' => $arrayData['Points'],
            'period_change' => false,
            'items' => []
        ];

        //Obtiene los items del carrito en session
        $session = Session::get("portal.cart.".SessionRegisterHdl::getCorbizCountryKey());
        $sessionInscription =  Session::get("portal.register.cart.".SessionRegisterHdl::getCorbizCountryKey());

        //FORs para obtener los datos id,description e image del carrito en session y agregarlos a los items en la cotizacion
        foreach ($arrayData['SalesWebItems']['dsSalesWebItems']['ttSalesWebItems'] as $it) {
            $itemCart = [];

            if($it['promo']){
                $dataItemPromo = PromoProd::where('clv_producto','=',$it['item'])->first();
                //dd($dataItemPromo);
                $itemCart['image'] = ShoppingCart::getImagePromoSpecial($it['item'], "promotions"); //Por definir imagen DEFAULT
                if($dataItemPromo != null){
                    //dd($dataItemPromo);
                    $itemCart['id'] = $dataItemPromo->id;
                    $itemCart['name'] = $dataItemPromo->name;
                    $itemCart['description'] = $dataItemPromo->description;
                    $itemCart['iskit'] = false;
                    $itemCart['is_special'] = false;
                } else {
                    $itemCart['id'] = 0;
                    $itemCart['name'] = $it['itemName'];
                    $itemCart['description'] = $it['itemName'];
                    $itemCart['iskit'] = false;
                    $itemCart['is_special'] = false;
                }

            }
            else{

                if(!empty($session)){
                    $findProductSupport = Product::where('sku', '=', $it['item'])->first();
                    if ($findProductSupport != null){
                        for ($i = 0; $i < sizeof($session['items']); $i++) {
                            if ($session['items'][$i]['sku'] == $it['item']) {
                                $itemCart['id'] = $session['items'][$i]['id'];
                                $itemCart['name'] = $session['items'][$i]['name'];
                                $itemCart['description'] = $session['items'][$i]['description'];
                                $itemCart['image'] = $session['items'][$i]['image'];
                                $itemCart['iskit'] = false;
                                $itemCart['is_special'] = false;
                                break;
                            }
                        }
                    } else {
                        $itemCart['id'] = 0;
                        $itemCart['name'] = $it['itemName'];
                        $itemCart['description'] = $it['itemName'];
                        $itemCart['image'] = ShoppingCart::getImagePromoSpecial($it['item'],"specials");; //Por definir imagen DEFAULT
                        $itemCart['iskit'] = false;
                        $itemCart['is_special'] = true;
                    }
                }

                if(!empty($sessionInscription)){
                    $findProductSupport = Product::where('sku', '=', $it['item'])->first();
                    if ($findProductSupport != null){
                        for ($i = 0; $i < sizeof($sessionInscription['items']); $i++) {
                            if($sessionInscription['items']['kit'] == $it['item'] ) {
                                $itemCart['id'] = $sessionInscription['items']['kitid'];
                                $itemCart['name'] = $sessionInscription['items']['kitname'];
                                $itemCart['description'] = $sessionInscription['items']['kitdescription'];
                                $itemCart['image'] = $sessionInscription['items']['kitimage'];
                                $itemCart['iskit'] = $sessionInscription['items']['iskit'];
                                $itemCart['is_special'] = false;
                                break;
                            }
                        }
                    } else {
                        for ($i = 0; $i < sizeof($sessionInscription['items']); $i++) {
                            if($sessionInscription['items']['kit'] == $it['item'] ) {
                                $itemCart['id'] = $sessionInscription['items']['kitid'];
                                $itemCart['description'] = '';
                                $itemCart['image'] = $sessionInscription['items']['kitimage'];
                                $itemCart['iskit'] = $sessionInscription['items']['iskit'];
                                $itemCart['is_special'] = false;
                                break;
                            }
                        }
                    }


                }

            }

            $items[] = [
                'id' => $itemCart['id'],
                'sku' => $it['item'],
                'name' => $it['itemName'],
                'description' => $itemCart['description'],
                'image' => $itemCart['image'],
                'listPrice' => $it['listPrice'],
                'discPrice' => $it['discPrice'],
                'points' => $it['points'],
                'iskit'  => $itemCart['iskit'],
                'promo' => $it['promo'],
                'quantity' => $it['quantity'],
                'unit_tax' => $it['unit_tx'],
                'tot_tax' => $it['tot_tax'],
                'is_special' => $itemCart['is_special']
            ];

        }


        //Funcion para editar el carrito con los productos devueltos en el WS addSalesWeb
        ShoppingCart::editShopingCartAddSalesWebWS($items);



        //Se guarda la cotizacion en session
        $sessionCheckout['items'] = $items;
        Session::put('portal.register.checkout.'.SessionRegisterHdl::getCorbizCountryKey().'.quotation', $sessionCheckout);
        //dd(Session::get("portal.checkout"));

        return true;

    }
    //Se obtienen los valores de la sesion del registro
    public static function getItemsQuotation(string $countryKey) : array {
        if (Session::has("portal.register.checkout.{$countryKey}.quotation.items")) {
            return Session::get("portal.register.checkout.{$countryKey}.quotation.items");
        }
        return [];
    }

    /**
     * getPointsAfterQuotation
     * Obtiene los puntos de los productos en el carrito desde la cotizacion
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @return int
     */
    public static function getPointsQuotation(string $countryKey) : int {
        return Session::has("portal.register.checkout.{$countryKey}.quotation.points") ? Session::get("portal.register.checkout.{$countryKey}.quotation.points") : 0;
    }

    /**
     * Obtiene el subtotal de los productos en el carrito formateados para una moneda desde la cotizacion
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $currencyKey   Clave de la moneda
     * @return string
     */
    public static function getSubtotalFormattedQuotation(string $countryKey, string $currencyKey) : string {
        return Session::has("portal.register.checkout.{$countryKey}.quotation.subtotal") ? currency_format(Session::get("portal.register.checkout.{$countryKey}.quotation.subtotal"), $currencyKey)  : currency_format(0, $currencyKey);
    }


    public static function getDiscountFormattedQuotation(string $countryKey, string $currencyKey) : string {
        return Session::has("portal.register.checkout.{$countryKey}.quotation.discount") ? Session::get("portal.register.checkout.{$countryKey}.quotation.discount")."%"  : "0%";
    }

    /**
     * Obtiene el manejo de los productos en el carrito formateados para una moneda desde la cotizacion
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $currencyKey   Clave de la moneda
     * @return string
     */
    public static function getHandlingFormattedQuotation(string $countryKey, string $currencyKey) : string {
        return Session::has("portal.register.checkout.{$countryKey}.quotation.handling") ? currency_format(Session::get("portal.register.checkout.{$countryKey}.quotation.handling"), $currencyKey)  : currency_format(0, $currencyKey);
    }

    /**
     * Obtiene los impuestos de los productos en el carrito formateados para una moneda desde la cotizacion
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $currencyKey   Clave de la moneda
     * @return string
     */
    public static function getTaxesFormattedQuotation(string $countryKey, string $currencyKey) : string {
        return Session::has("portal.register.checkout.{$countryKey}.quotation.taxes") ? currency_format(Session::get("portal.register.checkout.{$countryKey}.quotation.taxes"), $currencyKey)  : currency_format(0, $currencyKey);
    }

    /**
     * Obtiene el total de los productos en el carrito formateados para una moneda desde la cotizacion
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $currencyKey   Clave de la moneda
     * @return string
     */
    public static function getTotalFormattedQuotation(string $countryKey, string $currencyKey) : string {
        return Session::has("portal.register.checkout.{$countryKey}.quotation.total") ? currency_format(Session::get("portal.register.checkout.{$countryKey}.quotation.total"), $currencyKey)  : currency_format(0, $currencyKey);
    }







}