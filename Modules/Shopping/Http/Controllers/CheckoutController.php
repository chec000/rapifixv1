<?php

namespace Modules\Shopping\Http\Controllers;

use App\Helpers\CommonMethods;
use App\Helpers\RestWrapper;
use App\Helpers\TranslatableUrlPrefix;
use Illuminate\Routing\Controller;
use App\Helpers\SessionHdl;
use App\Helpers\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Entities\Country;
use Modules\Shopping\Entities\Bank;
use Modules\Shopping\Entities\ConfirmationBanner;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\Order;
use Modules\Shopping\Entities\OrderDetail;
use Modules\Shopping\Entities\PromoProd;
use Modules\Shopping\Entities\ShippingAddress;
use Modules\Shopping\Http\Controllers\traits\Payment;
use Modules\Shopping\Http\Controllers\traits\ShoppingCartPayment;
use PageBuilder;
use Response;
use View;

class CheckoutController extends Controller {

    use ShoppingCartPayment;

    public function __construct() {
        $this->CommonMethods = new CommonMethods();
    }

    public function redirect(){

        //return redirect("/shopping/checkout");
        return redirect(route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['shopping', 'checkout'])));
    }

    public function index(){

   
        if(session::has('portal.cart' ) && session::get('portal.cart.items') > 0) {

            return View::make('shopping::frontend.shopping.checkout.shippingaddress',
                [   'currency'         => SessionHdl::getCurrencyKey(),
                    'shoppingCart'     => ShoppingCart::getItems(SessionHdl::getCorbizCountryKey()),
                    'subtotal'         => ShoppingCart::getSubtotalFormatted(SessionHdl::getCorbizCountryKey(), SessionHdl::getCurrencyKey()),
                    'points'           => ShoppingCart::getPoints(SessionHdl::getCorbizCountryKey()),
                    'show_period_change' => SessionHdl::hasChoosePer() ? SessionHdl::getChoosePer() : false ,
                    'change_period'    => SessionHdl::hasPeriodChange() ? SessionHdl::getPeriodChange() : 0]
            );
        } else {
                return redirect('/');
        }
    }

    public function getShoppingCart(){

    }

    public function getShippingAddress($getFromWS = 0){

        if($getFromWS === "0" && session()->has('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list')
            && !empty(session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list'))){
            $result = array(
                'success' => true,
                'error' => "",
                'listShipmentAddress' => session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list'),
                'defaultShippmentAddress' => session()->has('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected') ?
                    session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected.folio') : false
            );

            return $result;
        }


        $countryKey = session()->get('portal.main.country_corbiz');
        $lang = session()->get('portal.main.language_corbiz');
        $distId = session()->get('portal.eo.distId');

        $urlWS = session()->get('portal.main.webservice');
        $restWrapper = new RestWrapper($urlWS."ShipmentAddress?CountryKey=$countryKey&Lang=$lang&DistId=$distId");
        $resultShipmentAddress = $restWrapper->call("GET",[],'json', ['http_errors' => false]);

        $defaultShippmentAddress = false;
        $defaultZipcode = false;
        $errors = "";
        $details = "";

        if ($resultShipmentAddress['success']) {
            $listShippingAddress = isset($resultShipmentAddress['responseWS']['response']['ShipmentAddress']['dsShipmentAddress']['ttShipmentAddress'])
                ? $this->transShippingAddress($resultShipmentAddress['responseWS']['response']['ShipmentAddress']['dsShipmentAddress']['ttShipmentAddress']) : 0;

            $defaultShippmentAddress = !empty($listShippingAddress) ? $this->getDefaultShippingAddress($listShippingAddress) : false;

            //$defaultZipcode = $defaultShippmentAddress == 0 ? session()->get('portal.main.zipCode') : false;
            $defaultZipcode = session()->get('portal.main.zipCode') != null ? session()->get('portal.main.zipCode') : false;

            $listShippingAddress = $this->getLabelsPermissionsShippingAddress($listShippingAddress);

            Session::put('portal.checkout.' . SessionHdl::getCorbizCountryKey() . '.shippingAddress.list', $listShippingAddress);

            //dd(session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list'));
        } else {

            if(isset($resultShipmentAddress['responseWS']['response']['ShipmentAddress']['dsShipmentAddress']['ttShipmentAddress'])
                && count($resultShipmentAddress['responseWS']['response']['ShipmentAddress']['dsShipmentAddress']['ttShipmentAddress']) > 0){
                $listShippingAddress = isset($resultShipmentAddress['responseWS']['response']['ShipmentAddress']['dsShipmentAddress']['ttShipmentAddress'])
                    ? $this->transShippingAddress($resultShipmentAddress['responseWS']['response']['ShipmentAddress']['dsShipmentAddress']['ttShipmentAddress']) : 0;

                $defaultShippmentAddress = !empty($listShippingAddress) ? $this->getDefaultShippingAddress($listShippingAddress) : false;

                //$defaultZipcode = $defaultShippmentAddress == 0 ? session()->get('portal.main.zipCode') : false;
                $defaultZipcode = session()->get('portal.main.zipCode') != null ? session()->get('portal.main.zipCode') : false;

                $listShippingAddress = $this->getLabelsPermissionsShippingAddress($listShippingAddress);

                Session::put('portal.checkout.' . SessionHdl::getCorbizCountryKey() . '.shippingAddress.list', $listShippingAddress);
            }

            $details = [];
            //Errores devueltos por el WS
            $errors = [];
            if(isset($resultShipmentAddress['responseWS']['response']['Error']['dsError']['ttError'])) {
                //Aquí va el flujo de varios mensajes de error del WS
                foreach ($resultShipmentAddress['responseWS']['response']['Error']['dsError']['ttError'] as $rsp){
                    /*
                     * *Agregado de nombre de direccion a los mensajes de error para identificarlos
                     */
                    $contains = str_contains($rsp['messTech'], (string)"Folio:");
                    if($contains){
                        list($messTech, $strFolio) =explode("Folio:", $rsp['messTech']);
                        list($idFolio, $strMessage) = explode(" ", trim($strFolio));
                        if((int)$idFolio == 0){
                            $rsp['messUser'] .= '(' . trans('shopping::shippingAddress.labels_error.address') . ': ' . trans('shopping::shippingAddress.labels_error.main_address'). ')';
                        } else {
                            //dd($listShippingAddress, $idFolio);
                            $rsp['messUser'] .= '(' . trans('shopping::shippingAddress.labels_error.address') . ': ' .
                                $listShippingAddress[$idFolio]['address'] . ')';
                        }
                    }

                    $details[] = [
                        'err_code' => $rsp['idError'],
                        'err_msg' => $rsp['messUser'],
                        'err_tech' => $rsp['messTech'],
                    ];

                    $errors[] = $rsp['messUser'];
                }

                //session()->flash('message-error-sw', $errors);
            } elseif(isset($resultShipmentAddress['message'])) {
                $errors[] = $resultShipmentAddress['message'];
                //session()->flash('message-error-sw', $errors);
            }
        }


        $result = array(
            'success' => $resultShipmentAddress['success'],
            'error' => $errors,
            'listShipmentAddress' => !empty($listShippingAddress) ? $listShippingAddress : "",
            'defaultShippmentAddress' => $defaultShippmentAddress,
            'defaultZipcode' => $defaultZipcode,
            'details' => !empty($details) ? $details : ""

            //'dataSession' => session()->all()
        );

        return $result;
    }

    private function getDefaultShippingAddress($data){
        //dd($data, count($data));
        if(session()->has('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected')){
            return session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected.folio');
        } elseif(count($data) == 1 && $data[0]['correct']) {
            session()->put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected', $data[0]);
            //var_dump(session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected'));
            return $data[0]['folio'];
        }elseif(session()->has('portal.main.zipCode') && !empty(session()->get('portal.main.zipCode'))){
            foreach ($data as $dt){
                if($dt['correct'] && $dt['zipcode'] == session()->get('portal.main.zipCode')){
                    session()->put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected', $dt);
                    //var_dump(session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected'));
                    return $dt['folio'];
                }
            }
        }
        return false;
    }

    private function getLabelsPermissionsShippingAddress($listShippingAddress){
        if(!empty($listShippingAddress)){
            foreach ($listShippingAddress as $index => $lsa){
                if($lsa['folio'] == 0){
                    $label = trans('shopping::shippingAddress.labels_error.main_address');
                } else {
                    $label = $lsa['label'];
                }
                switch(session()->get('portal.main.country_corbiz')){
                    case 'USA':
                        $listShippingAddress[$index]['labelSA'] = '<span class="radio-label t-direcciones">'.$label.'<span class="small t-direcciones">'.$lsa['address'].', '
                            .$lsa['county'].', '.$lsa['cityName'].' '.$lsa['stateKey'].'</span>';

                        $listShippingAddress[$index]['permissions']['canEdit'] = true;
                        $listShippingAddress[$index]['permissions']['canDelete'] = true;
                    break;
                    case 'MEX':
                        $listShippingAddress[$index]['labelSA'] = '<span class="radio-label t-direcciones">'.$label.'<span class="small t-direcciones">'.$lsa['address'].', '
                            .$lsa['suburb'].', '.$lsa['cityName'].' '.$lsa['stateKey'].'</span>';

                        $listShippingAddress[$index]['permissions']['canEdit'] = true;
                        $listShippingAddress[$index]['permissions']['canDelete'] = true;

                    break;
                }
            }
            return $listShippingAddress;
        }
        return false;
    }

    private function transShippingAddress($listShippingAddress){
        $returnListShippingAddress = [];
        foreach ($listShippingAddress as $index => $lsa) {

            $newSA = array(
                "distId" => trim($lsa['Dist_id']),
                "type" => trim($lsa['Tipo']),
                "folio" => trim($lsa['Folio']),
                "label" => trim($lsa['Etiqueta']),
                "addressId" => trim($lsa['iddireccion']),
                "name" => trim($lsa['Nombre']),
                "address" => trim($lsa['Direccion']),
                "number" => trim($lsa['Numero']),
                "complement" => trim($lsa['Complemento']),
                "suburb" => trim($lsa['Colonia']),
                "zipcode" => trim($lsa['CP']),
                "cityKey" => trim($lsa['Ciudad']),
                "cityName" => trim($lsa['Nombre_Cd']),
                "stateKey" => trim($lsa['Estado']),
                "county" => trim($lsa['Condado']),
                "countryKey" => trim($lsa['Clv_pais']),
                "email" => trim($lsa['correo']),
                "shippingCompany" => trim($lsa['comp_envio']),
                "phone" => trim($lsa['telefono']),
                "correct" => $lsa['correcta'],
            );

            //Validacion de correo, telefono y comnpania de envio, en caso de no existir o estar vacio marcara la direccion como correcta
            if(in_array($newSA['countryKey'],['USA', 'MEX'])) {
                if ((empty($newSA['email']) || $newSA['email'] === "" || $newSA['email'] === null)
                    || (empty($newSA['phone']) || $newSA['phone'] === "" || $newSA['phone'] === null)
                    || (empty($newSA['shippingCompany']) || $newSA['shippingCompany'] === "" || $newSA['shippingCompany'] === null)) {
                    $newSA['correct'] = false;
                }

                if ($this->validateAddressPOBOX($newSA['address'])) {
                    $newSA['correct'] = false;
                }
            }

            $returnListShippingAddress[$newSA['folio']] = $newSA;
        }

        return $returnListShippingAddress;
    }

    //Valida que la direccion no contenga PO BOX
    //Retorna true; si encuentra PO BOX, false; en caso de no encontrar PO BOX dentro de la die
    public function validateAddressPOBOX($address = null){
        if(!empty($address) || $address !== ""){

            $hasRestricteds = str_contains(strtoupper($address),config('shopping.validation_po_box'));

            if($hasRestricteds){
                return true;
            }else{
                return false;
            }
        }

        return false;
    }

    /**
     * Obtiene los estados correspondientes al país
     * @param  Request $request
     * @return Response
     */
    public function states(Request $request){
        return $this->CommonMethods->getStatesFromCorbiz(Session::get('portal.main.webservice'),Session::get('portal.main.country_corbiz'),Session::get('portal.main.language_corbiz'));
    }


    /**
     * Obtiene las ciudades correspondientes al país y estado
     * @param  Request $request
     * @return Response
     */
    public function citiesUSA(Request $request){

        $result = $this->CommonMethods->getCitiesFromCorbizUSAShippingAddress(Session::get('portal.main.webservice'),Session::get('portal.main.country_corbiz'),Session::get('portal.main.language_corbiz'),$request->state, $request->city);

        //dd($result);

        return  $result;

    }

    /**
     * Obtiene las ciudades correspondientes al país y estado
     * @param  Request $request
     * @return Response
     */
    public function cities(Request $request){

        return $this->CommonMethods->getCitiesFromCorbiz(Session::get('portal.main.webservice'),Session::get('portal.main.country_corbiz'),Session::get('portal.main.language_corbiz'),$request->state);

    }

    public function zipcode(Request $request){

        return $this->CommonMethods->getZipCodesFromCorbiz(Session::get('portal.main.webservice'),Session::get('portal.main.country_corbiz'),Session::get('portal.main.language_corbiz'),$request->zipCode);

    }

    public function shippingCompanies(Request $request){

        return $this->CommonMethods->getShippingCompanies($request->state,$request->city);

    }

    public function addShippingAddress(Request $request){
        //addShipmentAddress
        $urlWS = session()->get('portal.main.webservice');
        $restWrapper = new RestWrapper($urlWS."ShipmentAddress");
        $params = ['request' => [
            'CountryKey' => session()->get('portal.main.country_corbiz'),
            'Lang' => session()->get('portal.main.language_corbiz'),
            'ipcSource' => 'WEB',
            'ShipmentAddress' => [
                'ttShipmentAddress' => [
                    [
                        'Dist_id' => session()->get('portal.eo.distId'),
                        'Tipo' => 'ALTERNA',
                        'Folio' => '',
                        'Etiqueta' => $request->get('description'),
                        'iddireccion' => '',
                        'Nombre' => $request->get('name'),
                        'Direccion' => $request->get('address'),
                        'Numero' => '',
                        'Complemento' => $request->get('complement'),
                        'Colonia' => $request->has('suburb') ? $request->get('suburb') : '',
                        'CP' => $request->get('zip'),
                        'Ciudad' => $request->get('city'),
                        'Nombre_Cd' => $request->get('city_name'),
                        'Estado' => $request->get('state'),
                        'Condado' => $request->has('county') ? $request->get('county') : "",
                        'Clv_pais' => session()->get('portal.main.country_corbiz'),
                        'correo' =>  $request->has('email') ? $request->get('email') : "",
                        'comp_envio' => $request->get('shipping_company'),
                        'telefono' => $request->get('phone'),
                        'correcta' => true
                    ]
                ]
            ]
        ]];
        $resultAddShipmentAddress = $restWrapper->call("POST",$params,'json', ['http_errors' => false]);

        //dd($resultAddShipmentAddress);
        if ($resultAddShipmentAddress['success'] == true && isset($resultAddShipmentAddress['responseWS']['response']['ShipmentAddress']['dsShipmentAddress']['ttShipmentAddress'])) {
            $response = array(
                'status' => true,
                'Folio' => trim($resultAddShipmentAddress['responseWS']['response']['Folio']),
                'IDAddress' => trim($resultAddShipmentAddress['responseWS']['response']['IDAddress']),
                'title_message' => trans('shopping::shippingAddress.success_add'),
                'message_modal' => trans("shopping::shippingAddress.msg_address_add_success",
                    ['attribute' => trim($resultAddShipmentAddress['responseWS']['response']['ShipmentAddress']['dsShipmentAddress']['ttShipmentAddress']['0']['Etiqueta'])]),
            );
        } else {
            $response['status'] = false;
            $response['title_message'] = trans('shopping::shippingAddress.error_add');
            $response['message_modal'] = trans('shopping::shippingAddress.we_have_a_problem');

            $details = [];
            $errors = [];
            if (isset($resultAddShipmentAddress['responseWS']['response']['Error']['dsError']['ttError'])) {
                //errores del servicio falla al cotizar
                //Detalles de la respuesta para modal de más detalles

                foreach ($resultAddShipmentAddress['responseWS']['response']['Error']['dsError']['ttError'] as $key => $value)
                {
                    $details[] = [
                        'err_code' => $value['idError'],
                        'err_msg' => $value['messUser'],
                        'err_tech' => $value['messTech'],
                    ];

                    $errors[] = $value['messUser'];
                }
                $response['details'] = !empty($details) ? $details : "";

                $response['messages'] = $errors;
            } else {
                if (isset($resultAddShipmentAddress['data']['message'])) {
                    $response['messages'][] = $resultAddShipmentAddress['message'];
                } else {
                    $response['messages'][] = trans('shopping::zip.errors.404');
                }
                $response['details'] = "";
            }
        }

        //dd($resultAddShipmentAddress, $response);
        return $response;
    }

    public function postValidateAddShippinAddress(Request $request)
    {
        if ($request->ajax())
        {
            $key_messages = array();
            $value_messages = array();
            foreach (Config::get('shopping.shippingAddress.messages.' . Session::get('portal.main.country_corbiz') . '.addShippingAddress') as $keyMessage => $valueMessage)
            {
                $key_messages[] = $keyMessage;
                $value_messages[] = trans($valueMessage);
            }

            $key_labels = array();
            $value_labels = array();
            foreach (Config::get('shopping.shippingAddress.labels.' . Session::get('portal.main.country_corbiz') . '.addShippingAddress') as $keyLabel => $valueLabel)
            {
                $key_labels[] = $keyLabel;
                $value_labels[] = trans($valueLabel);
            }

            $rules = config('shopping.shippingAddress.rules.' . Session::get('portal.main.country_corbiz') . '.addShippingAddress');

            $messages   = array_combine($key_messages, $value_messages);

            $labels     = array_combine($key_labels, $value_labels);

            $validator = Validator::make($request->all(), $rules, $messages, $labels);

            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            return response()->json([
                'success'   => true,
                'message'   => '',
            ]);
        }
    }

    public function deleteShipmentAddress(Request $request){

        //dd($request->all());
        $urlWS = session()->get('portal.main.webservice');
        $distId = session()->get('portal.eo.distId');
        if($distId != null || !empty($distId)){
            $restWrapper = new RestWrapper($urlWS."ShipmentAddress?CountryKey=$request->country&Lang=$request->lang&DistId=$distId&Folio=$request->folio");
            $resultDeleteShipmentAddress = $restWrapper->call("DELETE",[],'json', ['http_errors' => false]);
            //dd($urlWS,$distId,$resultDeleteShipmentAddress);
            if ($resultDeleteShipmentAddress['success'] == true && isset($resultDeleteShipmentAddress['responseWS']['response']['Success'])) {
                if(session()->has('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected') && (int)$request->folio === (int)session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected.folio')){
                    session()->forget('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected');
                    session()->forget('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.quotation');
                }
                $response['status'] = true;
                $response['title_message'] = trans('shopping::shippingAddress.success_delete');
                $response['message_modal'] = trans('shopping::shippingAddress.msg_address_delete_success');

            } else {
                $response['status'] = false;
                $response['title_message'] = trans('shopping::shippingAddress.error_deleted');
                $response['message_modal'] = trans('shopping::shippingAddress.we_have_a_problem');

                $details = [];
                $errors = [];
                if (isset($resultDeleteShipmentAddress['responseWS']['response']['Error']['dsError']['ttError'])) {
                    //errores del servicio falla al cotizar
                    //Detalles de la respuesta para modal de más detalles

                    foreach ($resultDeleteShipmentAddress['responseWS']['response']['Error']['dsError']['ttError'] as $key => $value)
                    {
                        $details[] = [
                            'err_code' => $value['idError'],
                            'err_msg' => $value['messUser'],
                            'err_tech' => $value['messTech'],
                        ];

                        $errors[] = $value['messUser'];
                    }
                    $response['details'] = !empty($details) ? $details : "";;

                    $response['messages'] = $errors;
                } else {
                    if (isset($resultDeleteShipmentAddress['message'])) {
                        $response['messages'][] = $resultDeleteShipmentAddress['message'];
                    } else {
                        $response['messages'][] = trans('shopping::zip.errors.404');
                    }
                    $response['details'] = "";
                }
            }
            return $response;
        } else {
            return array(
                'status' => false,
                'title_message' => trans('shopping::shippingAddress.we_have_a_problem'),
                'message_modal' => trans('shopping::shippingAddress.session_eo_expired')
            );
        }
    }

    public function getEditShipmentAddress(Request $request){

        $shippmentAddress = false;

        if(!session()->has('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list') || empty(session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list'))) {
            $resultGSA = $this->getShippingAddress(1);
            session()->put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list', $resultGSA['listShipmentAddress']);
        }

        if(session()->has('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list') && !empty(session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list'))) {
            foreach(session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list') as $sa){
                if($sa['folio'] == $request['Folio']){
                    $shippmentAddress = $sa;
                }
            }

            $result = array(
                'status' => true,
                'messages' =>  array(trans("shopping::shippingAddress.msg_error_getAddress")),
                'listShipmentAddress' => session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list') != 0 ?
                    session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list') : "",
                'dataShippmentAddress' => $shippmentAddress,
                'details' => ""
            );

        } else {

            $result = array(
                'status' => false,
                'messages' =>  array(trans("shopping::shippingAddress.msg_error_getAddress")),
                'listShipmentAddress' => "",
                'dataShippmentAddress' => $shippmentAddress,
                'details' => ""
            );
        }

        return $result;
    }

    public function postValidateEditShippinAddress(Request $request)
    {
        if ($request->ajax())
        {
            $key_messages = array();
            $value_messages = array();
            foreach (Config::get('shopping.shippingAddress.messages.' . Session::get('portal.main.country_corbiz') . '.editShippingAddress') as $keyMessage => $valueMessage)
            {
                $key_messages[] = $keyMessage;
                $value_messages[] = trans($valueMessage);
            }

            $key_labels = array();
            $value_labels = array();
            foreach (Config::get('shopping.shippingAddress.labels.' . Session::get('portal.main.country_corbiz') . '.editShippingAddress') as $keyLabel => $valueLabel)
            {
                $key_labels[] = $keyLabel;
                $value_labels[] = trans($valueLabel);
            }

            $messages   = array_combine($key_messages, $value_messages);

            $labels     = array_combine($key_labels, $value_labels);

            $rules = config('shopping.shippingAddress.rules.' . Session::get('portal.main.country_corbiz') . '.editShippingAddress');

            //Si la direccion para editar es la principal(folio == 0) entonces se quita la regla para validar la descripcion, ya que el dato no viene en el post del formulario
            if($request->get("edit_folio") == 0){
                unset($rules['edit_description']);
            }

            $validator = Validator::make($request->all(), $rules, $messages, $labels);

            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            return response()->json([
                'success'   => true,
                'message'   => '',
            ]);
        }
    }

    public function editShippingAddress(Request $request){
        //dd($request->all(), $request->get('edit_complement'));
        $urlWS = session()->get('portal.main.webservice');
        $restWrapper = new RestWrapper($urlWS."ShipmentAddress");
        $params = ['request' => [
            'CountryKey' => session()->get('portal.main.country_corbiz'),
            'Lang' => session()->get('portal.main.language_corbiz'),
            'ipcSource' => 'WEB',
            'ShipmentAddress' => [
                'ttShipmentAddress' => [
                    [
                        'Dist_id' => session()->get('portal.eo.distId'),
                        'Tipo' => $request->get('edit_type'),
                        'Folio' => $request->get('edit_folio'),
                        'Etiqueta' => $request->get('edit_description') != null ? $request->get('edit_description') : "",
                        'iddireccion' => '',
                        'Nombre' => $request->get('edit_name'),
                        'Direccion' => $request->get('edit_address'),
                        'Numero' => '',
                        'Complemento' => $request->get('edit_complement') != null ? $request->get('edit_complement') : '',
                        'Colonia' => $request->has('edit_suburb') ? $request->get('edit_suburb') : '',
                        'CP' => $request->get('edit_zip'),
                        'Ciudad' => $request->get('edit_city'),
                        'Nombre_Cd' => $request->get('edit_city_name'),
                        'Estado' => $request->get('edit_state'),
                        'Condado' => $request->has('edit_county') ? $request->get('edit_county') : "",
                        'Clv_pais' => session()->get('portal.main.country_corbiz'),
                        'correo' =>  $request->has('edit_email') ? $request->get('edit_email') : "",
                        'comp_envio' => $request->get('edit_shipping_company'),
                        'telefono' => $request->get('edit_phone'),
                        'correcta' => true
                    ]
                ]
            ]

        ]];

        $resultEditShipmentAddress = $restWrapper->call("PUT",$params,'json', ['http_errors' => false]);

        //dd($resultEditShipmentAddress, $params);
        if ($resultEditShipmentAddress['success'] == true && isset($resultEditShipmentAddress['responseWS']['response']['ShipmentAddress']['dsShipmentAddress']['ttShipmentAddress'])) {
            $response['status'] = true;

            $response['data'] = array(
                'Folio' => trim($resultEditShipmentAddress['responseWS']['response']['Folio']),
                'IDAddress' => trim($resultEditShipmentAddress['responseWS']['response']['IDAddress']),
                'title_message' => trans('shopping::shippingAddress.success_edit'),
                'message_modal' => trans("shopping::shippingAddress.msg_address_edit_success",
                    ['attribute' => (int)$request->get('edit_folio') == 0 ? trans('shopping::shippingAddress.labels_error.main_address') : trim($resultEditShipmentAddress['responseWS']['response']['ShipmentAddress']['dsShipmentAddress']['ttShipmentAddress']['0']['Etiqueta'])]),
            );

        } else {
            $response['status'] = false;
            $response['data']['title_message'] = trans('shopping::shippingAddress.error_add');
            $response['data']['message_modal'] = trans('shopping::shippingAddress.we_have_a_problem');

            $details = [];
            $errors = [];
            if (isset($resultEditShipmentAddress['responseWS']['response']['Error']['dsError']['ttError'])) {
                //errores del servicio falla al cotizar
                //Detalles de la respuesta para modal de más detalles

                foreach ($resultEditShipmentAddress['responseWS']['response']['Error']['dsError']['ttError'] as $key => $value)
                {
                    $details[] = [
                        'err_code' => $value['idError'],
                        'err_msg' => $value['messUser'],
                        'err_tech' => $value['messTech'],
                    ];

                    $errors[] = $value['messUser'];
                }

                $response['data']['details'] = !empty($details) ? $details : "";

                $response['data']['messages'] = $errors;
            } else {
                if (isset($resultEditShipmentAddress['message'])) {
                    $response['data']['messages'][] = $resultEditShipmentAddress['message'];
                } else {
                    $response['data']['messages'][] = trans('shopping::zip.errors.404');
                }
                $response['data']['details'] = "";
            }
        }

        return $response;
    }

    /*
    *Funcion para seleccionar una dirección del listado de direcciones
    */
    public function selectShippingAddress($folio){

        if(!session()->has('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list') || empty(session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list'))) {
            $resultGSA = $this->getShippingAddress(1);
            session()->put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list', $resultGSA['listShipmentAddress']);
        }
        $resultASW = false;
        $zipCode = false;
        if(session()->has('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list') && session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list') != 0) {
            foreach(session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list') as $sa){
                if($sa['folio'] == $folio){
                    session()->put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected', $sa);

                    $zipCode = $sa['zipcode'];
                    //Actualizacion de datos zipcode, city_key, state_key y corbiz_warehouse en session tomando la nueva direccion
                    switch(Session::get('portal.main.type_warehouse')){
                        case "ZIPCODE":
                            //dd($sa);

                            $dataWH = array(
                                'stateKey' =>"",
                                'cityKey' => "",
                                'zipcode' => $sa['zipcode']);

                            $resultValidateAvailableWH = $this->getAvailableWH($dataWH);
                            if($resultValidateAvailableWH){
                                Session::put('portal.main.zipCode', $sa['zipcode']);
                                Session::put('portal.main.corbiz_warehouse', $resultValidateAvailableWH);
                            }
                            break;
                        case "CITY":
                            $dataWH = array(
                                'stateKey' => $sa['stateKey'],
                                'cityKey' => $sa['cityKey'],
                                'zipcode' => "");
                            $resultValidateAvailableWH = $this->getAvailableWH($dataWH);
                            if($resultValidateAvailableWH){
                                Session::put('portal.main.cityKey_corbiz', $sa['cityKey']);
                                Session::put('portal.main.stateKey_corbiz', $sa['stateKey']);
                                Session::put('portal.main.corbiz_warehouse', $resultValidateAvailableWH);
                            }
                            break;
                    }


                    Session::forget("portal.checkout.".SessionHDL::getCorbizCountryKey().".promotions");
                    Session::forget('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTemp');
                    Session::forget("portal.checkout.".SessionHdl::getCorbizCountryKey().".promotionsSent");


                    $resultASW = $this->initQuotation($sa);
                    //dd($resultASW, $sa);
                    break;
                }
            }


            $result = array(
                'products' => ShoppingCart::getItems(SessionHdl::getCorbizCountryKey()),
                'resultASW' => $resultASW,
                'status' => true,
                'zipcode' => $zipCode,
                'messages' =>  array(trans("shopping::shippingAddress.success_selected")),
                'title_message' => trans('shopping::shippingAddress.select_new_shipping_address'),
                'message_modal' => trans("shopping::shippingAddress.success_selected"),
            );

        } else {
            $result = array(
                'status' => false,
                'resultASW' => $resultASW,
                'messages' =>  array(trans("shopping::shippingAddress.error_selected")),
                'title_message' => trans('shopping::shippingAddress.select_new_shipping_address'),
                'message_modal' => trans("shopping::shippingAddress.success_selected"),
            );
        }

        return $result;
    }

    public function getInitQuotation($process = "checkout"){
            Session::forget('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTemp');
            Session::forget('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsSent');
            $address = session()->get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected');

            return $this->initQuotation($address, $process);

    }

    public function getInitQuotationPromos($process = "checkout"){
        if(session()->has('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected')){
            $address = session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected');

            //return $this->initQuotation($address, $process);
        } else {
            $resultGSA = $this->getShippingAddress(1);
            session()->put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.list', $resultGSA['listShipmentAddress']);
            $address = session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.shippingAddress.selected');
        }

        return $this->initQuotation($address, $process);

    }
    /*
     * initQuotation()
     * Inicia con el proceso de cotizacion
     *
     * Recibe array $shippingAddress, que contiene la direccion seleccionada por el usuario
     * */
    public function initQuotation($shippingAddress, $process = "checkout"){

        //dd(SessionHdl::getTypeWarehouse());
        //Proceso para obtener el almacen con el que se realizara la cotizacion
        session()->forget('portal.checkout.'.SessionHdl::getCorbizCountryKey().'quotation');
        $resultValidateAvailableWH = false;
        switch(SessionHdl::getTypeWarehouse()){
            case 'UNIQUE':
                ShoppingCart::validateProductWarehouse(SessionHdl::getCorbizCountryKey(), SessionHdl::getWarehouse());
                ShoppingCart::validateProductRestrictionState(SessionHdl::getCorbizCountryKey(), $shippingAddress['stateKey']);
                $resultValidateAvailableWH = true;
                break;
            case 'CITY':
                $data = array(
                    'stateKey' => $shippingAddress['stateKey'],
                    'cityKey' => $shippingAddress['cityKey'],
                    'zipcode' => ""
                );
                $resultValidateAvailableWH = $this->getAvailableWH($data);
                if($resultValidateAvailableWH != false){
                    ShoppingCart::validateProductWarehouse(SessionHdl::getCorbizCountryKey(), $resultValidateAvailableWH);
                    ShoppingCart::validateProductRestrictionState(SessionHdl::getCorbizCountryKey(), $shippingAddress['stateKey']);
                }
                break;
            case 'ZIPCODE':
                $data = array(
                    'stateKey' => "",
                    'cityKey' => "",
                    'zipcode' => $shippingAddress['zipcode']
                );
                $resultValidateAvailableWH = $this->getAvailableWH($data);
                //dd($resultValidateAvailableWH);
                if ($resultValidateAvailableWH != false) {
                    ShoppingCart::validateProductWarehouse(SessionHdl::getCorbizCountryKey(), $resultValidateAvailableWH);
                    ShoppingCart::validateProductRestrictionState(SessionHdl::getCorbizCountryKey(), $shippingAddress['stateKey']);
                }
                break;
            default:
                $result = array(
                    'products' => ShoppingCart::getItems(SessionHdl::getCorbizCountryKey()),
                    'resultASW' => false,
                    'status' => false,
                    'messages' =>  array(trans('shopping::zip.errors.404')),
                    'title_message' => trans('shopping::shippingAddress.we_have_a_problem'),
                    'message_modal' => trans('shopping::zip.errors.404'),
                );
                return $result;
                break;
        }

        //$resultASW = false;

        // Si existe almacen, realiza la peticion al WS addSalesWeb
        if($resultValidateAvailableWH != false) {
            return $this->getAddSalesWebWS($shippingAddress, $process);
        } else {
            //Aqui se va a mandar un mensaje de error, de no disponbilidad de servicios
            return Response::json(false);
        }
        //return $resultASW;
    }

    /*
     * getAvailableWH()
     * Obtiene el WH con los datos de dirección obtenidos
     *
     * Recibe array dataAddress
     * */
    public function getAvailableWH($dataAddress){
        //getAvailableWH 90210
        //dd($dataAddress);
        $restWrapper = new RestWrapper(SessionHdl::getRouteWS()."getAvailableWH?CountryKey=".SessionHdl::getCorbizCountryKey().
            "&Lang=".SessionHdl::getCorbizLanguage()."&StateKey=".$dataAddress['stateKey']."&CityKey=".$dataAddress['cityKey']."&ZipCode=".$dataAddress['zipcode']);
        $resultWH = $restWrapper->call("GET",[],'json', ['http_errors' => false]);
        //dd($resultWH);
        if($resultWH['success']){
            if(isset($resultWH['responseWS']['response']['Warehouse']['dsWarehouse']['ttWarehouse'][0]['warehouse'])){
                return trim($resultWH['responseWS']['response']['Warehouse']['dsWarehouse']['ttWarehouse'][0]['warehouse']);
            }
            return false;
        }
        return false;
    }

    /**
     * getAddSalesWebWS
     *
     * @return mixed            Array con los items del carrito en formato para ser enviados en el WS addSalesWeb
     */
    public function getItemsFormatedAddSalesWebWS($process){
        //dd(ShoppingCart::getItems(SessionHdl::getCorbizCountryKey()));
        $arrayItems = array();
        $count = 0;
        foreach(ShoppingCart::getItems(SessionHdl::getCorbizCountryKey()) as $index => $isc){
            $arrayItems[] = [
                'numline' => $count,
                'countrysale' => SessionHdl::getCorbizCountryKey(),
                'item' => $isc['sku'],
                'quantity ' => $isc['quantity'],
                'listPrice' => $isc['price'],
                'discPrice' => '',
                'points' => $isc['points'],
                'promo' => false
            ];
            $count++;
        }

        if(SessionHdl::hasPromotionItems($process)){
            foreach(SessionHdl::getPromotionItems($process) as $index => $promotion){
                foreach($promotion as $isc){
                    $isc['numline'] = $count;
                    $arrayItems[] = $isc;
                    $count++;
                }
            }
        }

        //dd(ShoppingCart::getPromotionItems(SessionHdl::getCorbizCountryKey()), $arrayItems);
        return $arrayItems;
    }

    /**
     * getAddSalesWebWS
     * * @param Array $dataAddSalesWeb Contiene los datos necesarios para el WS y los productos del carrito formateados
     * @return mixed            Respuesta del WS
     */

    public function getAddSalesWebWS($dataShippingAddress = array(), $process = "checkout") {

        $shoppingCartController = new ShoppingCartController();
        //Genera todas
        $defaultCodePaid = config('shopping.paymentCorbizRelation.' . SessionHdl::getCorbizCountryKey() . '.default');
        $arrayItems = $this->getItemsFormatedAddSalesWebWS($process);

        //Validacion para que en caso de que la cotizacion no lleve productos, retorne false salga del proceso de cotizacion
        if(empty($arrayItems)){
            //dd($arrayItems);
            $dataResult['products'] = ShoppingCart::getItems(SessionHdl::getCorbizCountryKey());
            $dataResult['success'] = false;
            $dataResult['requotation'] = false;
            $dataResult['existsPromotions'] = false;
            $dataResult['showButtonProducts'] = true;
            $dataResult['details'] = "";

            SessionHdl::forgetPromotionItems();


            SessionHdl::forgetMessageErrorSW();
            $dataResult['viewErrors'] = $this->getResumeCartViewErrors();
            //dd($dataResult);

            return $dataResult;
        }

        $dataASW = array(
            'dataAddress' => $dataShippingAddress,
            'arrayItems' => $arrayItems,
            'cartResume' => $shoppingCartController->getCartResume(),
            'codePaid' => config('shopping.paymentCorbizRelation.' . SessionHdl::getCorbizCountryKey() . '.' . $defaultCodePaid)
        );
        //dd($dataASW);
        $restWrapper = new RestWrapper(SessionHdl::getRouteWS()."addSalesWeb");
        $params = ['request' => [
            'CountryKey' => SessionHdl::getCorbizCountryKey(),
            'Lang' => SessionHdl::getCorbizLanguage(),
            'SalesWeb' => [
                'ttSalesWeb' => [
                    [
                        'countrysale' => SessionHdl::getCorbizCountryKey(),
                        'no_trans' => '',
                        'distributor' =>  SessionHdl::getDistributorId(),
                        'amount' => $dataASW['cartResume']['subtotal'],
                        'receiver' => $dataASW['dataAddress']['name'],
                        'address' => $dataASW['dataAddress']['address'],
                        'number' => '',
                        'suburb' => ($dataASW['dataAddress']['suburb'] != "") ? $dataASW['dataAddress']['suburb'] : "" ,
                        'complement' => $dataASW['dataAddress']['complement'],
                        'state' => $dataASW['dataAddress']['stateKey'],
                        'city' => $dataASW['dataAddress']['cityKey'],
                        'county' => $dataASW['dataAddress']['county'],
                        'zipcode' => $dataASW['dataAddress']['zipcode'],
                        //'shippingcompany' => "",
                        'shippingcompany' => $dataASW['dataAddress']['shippingCompany'],
                        'altAddress' => 0,
                        'email' => $dataASW['dataAddress']['email'],
                        'phone' => $dataASW['dataAddress']['phone'],
                        'previousperiod' => false,
                        'source' => 'WEB',
                        'type_mov'=> 'VENTA',
                        'codepaid' => $dataASW['codePaid'],
                        'zcreate' => false
                    ]
                ],
            ],
            'SalesWebItems' => [
                'ttSalesWebItems' => $dataASW['arrayItems']
            ]
        ]];
        //dd($params);
        $resultQuoteWeb = $restWrapper->call("POST",$params,'json', ['http_errors' => false]);
        //dd($params,$resultQuoteWeb);
        $resultData = $this->getResultDataAddSalesWeb($resultQuoteWeb, $process);

        if($resultData['requotation']){
            return $this->getAddSalesWebWS($dataShippingAddress, $process);
        } else {
            $resultData['viewErrors'] = $this->getResumeCartViewErrors();
            $resultData['products'] = ShoppingCart::getItems(SessionHdl::getCorbizCountryKey());

            return $resultData;
        }
    }

    /**
     * getResultDataAddSalesWeb
     *
     * @param String $corbizKey Llave CorBiz del país
     * @return mixed            Vista renderizada de los métodos de pago
     */
    public function getResultDataAddSalesWeb($responseWS, $process){

        $dataResult = array();
        //cotizacion exitosa
        if($responseWS['success'] && $responseWS['responseWS']['response']['Success'] == 'true')
        {
            //dd($responseWS);
            ShoppingCart::setSessionCartAddSalesWeb($responseWS['responseWS']['response']);
            $dataResult['success'] = true;
            $dataResult['requotation'] = false;
            $dataResult['response'] = $responseWS['responseWS']['response'];
            $dataResult['showButtonProducts'] = false;

            // Eliminando errores de existencias de WS para no pintarlos en Vista
            $dataResult['details'] = "";
            if(session()->exists('delete-items')){
                SessionHdl::forgetMessageErrorSW();
            }
            //$dataResult['viewErrors'] = $this->getResumeCartViewErrors();
            $dataResult['existsPromotions'] = false;
            //Armado de arreglo de promociones
            if(isset($responseWS['responseWS']['response']['HedPromo']['dsHedPromo']['thedPromo'])
                && isset($responseWS['responseWS']['response']['DetPromo']['dsDetPromo']['tdetPromo'])){
                $promotionController = new PromotionController();
                $dataResult['existsPromotions'] = $promotionController->initPromotions($responseWS['responseWS']['response']['HedPromo']['dsHedPromo']['thedPromo']
                    ,$responseWS['responseWS']['response']['DetPromo']['dsDetPromo']['tdetPromo'], $process );

                //dd(Session::get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.promotionsSent'), $responseWS['responseWS']['response']);
            }

            return $dataResult;

        }else if(!$responseWS['success']  && $responseWS['responseWS']['response']['Success'] == 'false' && isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])){

            // Llamada a metodo para remover articulos de caso de que el error de cotizacion se deba a falta de productos
            $requotation = ShoppingCart::removeItemsCartAddSalesWebWS($responseWS['responseWS']['response']['Error']['dsError']['ttError']);

            $dataResult['success'] = false;
            $dataResult['requotation'] = $requotation;
            $dataResult['response'] = $responseWS['responseWS']['response']['Error']['dsError']['ttError'];
            $dataResult['showButtonProducts'] = false;

            //errores del servicio falla al cotizar, Detalles de la respuesta para modal de más detalles
            $details = [];
            $errors = [];


            if(isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                foreach ($responseWS['responseWS']['response']['Error']['dsError']['ttError'] as $key => $value)
                {
                    $details[] = [
                        'err_code' => $value['idError'],
                        'err_msg' => $value['messUser'],
                        'err_tech' => $value['messTech'],
                    ];

                    $errors[] = $value['messUser'];
                }
                session()->flash('message-error-sw', $errors);
            } elseif(isset($responseWS['message'])) {
                $errors[] = $responseWS['message'];
                session()->flash('message-error-sw', $errors);
            }

            $dataResult['details'] = !empty($details) ? $details : "";

            return $dataResult;
        }else{

            $dataResult['success'] = false;
            $dataResult['requotation'] = false;
            $dataResult['existsPromotions'] = false;
            $dataResult['response'] = $responseWS['message'];
            $dataResult['showButtonProducts'] = false;

            //Si el error devuelto por el WS es debido a un producto no diponible, no se pinta el mensaje de error de corbiz
            //Detalles de la respuesta para modal de más detalles
            $details = [];
            $errors = [];

            if(isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                foreach ($responseWS['responseWS']['response']['Error']['dsError']['ttError'] as $key => $value)
                {
                    $details[] = [
                        'err_code' => $value['idError'],
                        'err_msg' => $value['messUser'],
                        'err_tech' => $value['messTech'],
                    ];

                    //Aquí va el flujo de varios mensajes de error del WS
                    $errors[] = $value['messUser'];
                }

                session()->flash('message-error-sw', $errors);
            } elseif(isset($responseWS['message'])) {
                $errors[] = $responseWS['message'];
                session()->flash('message-error-sw', $errors);
            }

            $dataResult['details'] = !empty($details) ? $details : "";

            return $dataResult;
        }
    }

    /**
     * getResumeCartViewAfterQuotation
     *
     * @return mixed    Vista renderizada del resumen de compra
     */
    public function getResumeCartViewAfterQuotation() {

        $arrayViews = array('items' => "", 'totals' => "" );
        $corbizCountry      = strtolower(SessionHdl::getCorbizCountryKey());
        if(View::exists("shopping::frontend.shopping.includes.{$corbizCountry}.cart_preview_items_{$corbizCountry}")) {
            $viewItems = View::make("shopping::frontend.shopping.includes.{$corbizCountry}.cart_preview_items_{$corbizCountry}",
                [
                    'currency' => SessionHdl::getCurrencyKey(),
                    'shoppingCart' => ShoppingCart::getItemsQuotation(SessionHdl::getCorbizCountryKey()),
                ]
            );
            $arrayViews['items'] = (string)$viewItems;
        }
        if(View::exists("shopping::frontend.shopping.includes.{$corbizCountry}.cart_preview_resume_{$corbizCountry}")) {
            $viewTotals = View::make("shopping::frontend.shopping.includes.{$corbizCountry}.cart_preview_resume_{$corbizCountry}",
                [
                    'currency' => SessionHdl::getCurrencyKey(),
                    'subtotal' => ShoppingCart::getSubtotalFormattedQuotation(SessionHdl::getCorbizCountryKey(), SessionHdl::getCurrencyKey()),
                    'discount' => ShoppingCart::getDiscountFormattedQuotation(SessionHdl::getCorbizCountryKey(), SessionHdl::getCurrencyKey()),
                    'points' => ShoppingCart::getPointsQuotation(SessionHdl::getCorbizCountryKey()),
                    'handle' => ShoppingCart::getHandlingFormattedQuotation(SessionHdl::getCorbizCountryKey(), SessionHdl::getCurrencyKey()),
                    'taxes' => ShoppingCart::getTaxesFormattedQuotation(SessionHdl::getCorbizCountryKey(), SessionHdl::getCurrencyKey()),
                    'total' => ShoppingCart::getTotalFormattedQuotation(SessionHdl::getCorbizCountryKey(), SessionHdl::getCurrencyKey()),
                    'show_period_change' => SessionHdl::hasChoosePer() ? SessionHdl::getChoosePer() : false ,
                    'change_period'    => SessionHdl::hasPeriodChange() ? SessionHdl::getPeriodChange() : 0
                ]
            );

            $arrayViews['totals'] = (string)$viewTotals;
        }
        //dd($arrayViews);
        return $arrayViews;
    }

    /**
     * getResumeCartViewErrors
     *
     * @return mixed    Vista renderizada de los errores de la cotizacion
     */
    public function getResumeCartViewErrors() {
        //dd(session()->get('message-error-sw'));
        $viewErrors = "";
        if(View::exists("shopping::frontend.shopping.includes.resume_quotation_errors")) {
            $viewErrors = View::make("shopping::frontend.shopping.includes.resume_quotation_errors");
        }
        //dd((string)$viewErrors);
        return (string)$viewErrors;
    }

    /**
     * getViewModalPromotions
     *
     * @return mixed    Vista renderizada del modal de promociones
     */
    public function getViewModalPromotions($process = "checkout") {

        //dd(Session::get("portal.{$process}.".SessionHdl::getCorbizCountryKey().".promotions"));
        if(View::exists("shopping::frontend.shopping.includes.promotions.modal_promo")) {
            return View::make("shopping::frontend.shopping.includes.promotions.modal_promo",
                [
                    'promotions' => Session::get("portal.{$process}.".SessionHdl::getCorbizCountryKey().".promotions"),
                    'process' => $process
                ]
            );
        } else {
            return false;
        }
    }

    /**
     * setChangePeriodSession
     * @param int       Recibe el periodo (1 = true, 0 = false)para modificarlo en sesion
     * @return mixed    Resultado del cambio de periodo en sesion
     */
    public function setChangePeriodSession($changePeriod){
        $result = array(
            'success' => false,
            'message' => trans('shopping::checkout.quotation.change_period_fail_msg')
        );

        if(SessionHdl::hasPeriodChange()){
            session()->put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.quotation.period_change', (int)$changePeriod);
            $result = array(
                'success' => true,
                'message' => trans('shopping::checkout.quotation.change_period_success_msg')
            );
        }
        return response()->json($result);
    }

    public function validateDataQuotationToStep2(){

        $result = array(
            'success' => false
        );

        if(SessionHdl::hasQuotation()){
            $quotation = SessionHdl::getQuotation();
            if(!empty($quotation['items']) && count($quotation['items']) > 0){
                if((!empty($quotation['total']) && $quotation['total'] != null && $quotation['total'] != "")){
                    $result = array(
                        'success' => true,
                    );
                }
            }
        }

        return response()->json($result);
    }

    # QUOTATION VIEW AJAX METHODS
    # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
    /**
     * getPaymentView
     *
     * @return mixed    Vista renderizada de los métodos de pago
     */
    public function getPaymentView() {
        $countryId      = Session::get('portal.main.country_id');
        $paymentMethods = $this->CommonMethods->getBanks($countryId);
        $corbizKey      = strtolower(SessionHdl::getCorbizCountryKey());

        return View::make("shopping::frontend.shopping.includes.{$corbizKey}.payment.form_payment", [
            'paymentMethods' => $paymentMethods['success'] ? $paymentMethods['data'] : collect([]),
        ]);
    }

    /**
     * getCartPreview
     *
     * @return mixed    Vista renderizada del resúmen del carrito de compras
     */
    public function getCartPreview() {
        $sessionCart = $this->getQuotation();
        $corbizKey   = strtolower(SessionHdl::getCorbizCountryKey());

        return View::make("shopping::frontend.shopping.includes.{$corbizKey}.payment.cart_onlyread", [
            'sessionCart' => $sessionCart,
        ]);
    }


    # PAYMENT AJAX METHODS
    # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
    /**
     * processCorbizTransaction
     * Genera una transacción en CorBiz y guarda la orden en la base de datos
     *
     * @param Request $request  Petición HTTP
     * @return array
     */
    public function processCorbizTransaction(Request $request) {
        $response = ['status' => false];
        $date     = new \DateTime('now', new \DateTimeZone(SessionHdl::getTimeZone()));

        if ($request->ajax()) {
            $paymentMethodId = $request->input('paymentMethod');

            if (!SessionHdl::hasPaymentMethod()) {
                Session::put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.paymentMethod', $paymentMethodId);
            }

            if (!SessionHdl::hasTransaction() || $this->hasChangesInQuotation() || $this->hasChangeInAddress()) {
                if (SessionHdl::hasShippingAddress()) {
                    $country       = Country::find(SessionHdl::getCountryID());
                    $salesWeb      = $this->getWSSalesWeb();      # Info para el servicio
                    $salesWebItems = $this->getWSSalesWebItems(); # Info para el servicio

                    if (!empty($salesWebItems)) {
                        $responseWs = $this->CommonMethods->getTransactionFromCorbiz($country->webservice, SessionHdl::getCorbizCountryKey(), SessionHdl::getCorbizLanguage(), $salesWeb, $salesWebItems);

                        if ($responseWs['status']) {
                            Session::put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.transaction', $responseWs['data']['transaction']);
                            $response = $this->saveOrder();
                        } else {
                            $response['status'] = false;
                            $response['errors'] = $responseWs['messages'];
                            $response['err']    = $responseWs['err'];
                        }
                    } else {
                        $response['status']        = false;
                        $response['errors']        = [trans("shopping::checkout.payment.errors.address")];
                        $response['back_to_step1'] = true;
                    }

                } else {
                    $response['errors'] = [trans("shopping::checkout.payment.errors.sys005")];
                }
            } else {
                if ($paymentMethodId != SessionHdl::getPaymentMethod()) {
                    Session::put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.paymentMethod', $paymentMethodId);
                    Order::where('corbiz_transaction', SessionHdl::getTransaction())->update([
                        'bank_id'          => $paymentMethodId,
                        'bank_transaction' => '',
                        'payment_brand'    => '',
                        'updated_at'       => $date->format('Y-m-d H:i:s')
                    ]);
                }

                if (!Order::exists('corbiz_transaction', SessionHdl::getTransaction())) {
                    $response = $this->saveOrder();
                } else {
                    $response['status'] = true;
                }
            }

            # Regresamos a la vista la clave del método de pago y el número de orden
            $paymentMethod = Bank::find($paymentMethodId);
            $order         = Order::where('corbiz_transaction', SessionHdl::getTransaction())->first();

            if ($order != null) {
                $response['method_key'] = $paymentMethod->bank_key;
                $response['order']      = $order->order_number;
            }
        }

        return $response;
    }

    /**
     * confirmation
     * Recibe el número de la orden y muestra la vista de confirmación correspondiente
     *
     * @param $orderNumber
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmation(Request $request) {
        if ($request->method() == 'POST') {
            $orderNumber = $request->input('order');
            $order       = Order::where('order_number', $orderNumber)->first();
            $shipping    = ShippingAddress::where('order_id', $order->id)->first();
            $date        = new \DateTime('now', new \DateTimeZone(SessionHdl::getTimeZone()));
            $country     = Country::find(SessionHdl::getCountryID());
            $type        = false;

            # Confirmation View Success
            if ($order->order_estatus_id == $this->CommonMethods->getOrderStatusId('PAYMENT_SUCCESSFUL', SessionHdl::getCountryID())) {
                $salesWeb = $this->getWSSalesWebDB(true, ['column' => 'order_number', 'value' => $orderNumber]);
                $salesWebItems = $this->getWSSalesWebItemsDB(['column' => 'order_number', 'value' => $orderNumber]);
                $responseWs = $this->CommonMethods->getOrderFromCorbiz($country->webservice, SessionHdl::getCorbizCountryKey(), SessionHdl::getCorbizLanguage(), $salesWeb, $salesWebItems);

                if ($responseWs['status']) {
                    # ORDER COMPLETE
                    $type = 'success';
                    Order::where('order_number', $order->order_number)->update([
                        'order_estatus_id' => $this->CommonMethods->getOrderStatusId('ORDER_COMPLETE', SessionHdl::getCountryID()),
                        'corbiz_order_number' => $responseWs['data']['order'],
                        'updated_at' => $date->format('Y-m-d H:i:s'),
                    ]);

                    # Email de confirmación de la orden
                    $supportEmails = Config::get('cms.email_send');
                    $fromEmail = $supportEmails[SessionHdl::getCorbizCountryKey()];

                    $eo = SessionHdl::getEo();
                    if (!empty($eo['email'])) {
                        $toEmail = $eo['email'];
                        $toName = $eo['name1'];
                    } else {
                        $toEmail = $shipping->email;
                        $toName = $shipping->eo_name;
                    }

                    $mailInfo = [
                        'first_name'   => $eo['name1'],
                        'order_number' => $responseWs['data']['order'],
                        'addr_name'    => $shipping->eo_name,
                        'address'      => "{$shipping->address} {$shipping->city_name}, {$shipping->state}",
                        'items'        => $this->getItemsToMail($order->id),
                        'detail'       => $this->getOrderDetail($order->id),
                    ];

                    Mail::send('shopping::frontend.shopping.includes.' . strtolower(SessionHdl::getCorbizCountryKey()) . '.mails.payment_success_order_corbiz', $mailInfo,
                        function ($m) use ($fromEmail, $toEmail, $toName) {
                            $m->from($fromEmail, trans('shopping::register_customer.mail_address.title'));
                            $m->to($toEmail, $toName)->subject(trans('shopping::checkout.confirmation.emails.order_success'));
                        });
                } else {
                    # NO ORDER BY CORBIZ ERROR
                    $type = 'no_order';

                    Order::where('order_number', $order->order_number)->update([
                        'order_estatus_id' => $this->CommonMethods->getOrderStatusId('CORBIZ_ERROR', SessionHdl::getCountryID()),
                        'updated_at'       => $date->format('Y-m-d H:i:s'),
                        'error_user'       => $responseWs['err_order']['error_user'],
                        'error_corbiz'     => $responseWs['err_order']['error_corbiz']
                    ]);

                    unset($responseWs['err_order']);
                }
            } else if ($order->order_estatus_id == $this->CommonMethods->getOrderStatusId('PAYMENT_PENDING', SessionHdl::getCountryID())) {
                # ORDER PENDING
                $type = 'pending';
            }

            if ($type === false) {
                return redirect()->route(TranslatableUrlPrefix::getRouteName(SessionHdl::getLocale(), ['products', 'index']));
            }

            return $this->confirmationView($orderNumber, $type, $responseWs);
        } else {
            # ToDo Integrar la Confirmation View Error para los casos en que los bancos redirigen a nuestra url
            return redirect()->route(TranslatableUrlPrefix::getRouteName(SessionHdl::getLocale(), ['products', 'index']));
        }
    }

    /**
     * confirmationView
     * Carga alguna de las vistas de confirmación. [success, pending, no_order]
     *
     * @param $orderNumber          Número de la orden
     * @param $type                 Tipo de la vista
     * @return mixed
     */
    private function confirmationView($orderNumber, $type, $response = []) {
        $order    = Order::where('order_number', $orderNumber)->first();
        $items    = OrderDetail::where('order_id', $order->id)->get();
        $shipping = ShippingAddress::where('order_id', $order->id)->first();

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

        $this->forgetSession(SessionHdl::getCorbizCountryKey());

        $banners    = $this->getBanners('success', 'shopping', SessionHdl::getCountryID(), SessionHdl::getBrandID());
        $countryKey = strtolower(SessionHdl::getCorbizCountryKey());

        return View::make("shopping::frontend.shopping.includes.{$countryKey}.payment.confirmation.confirmation", [
            'type'     => $type,
            'order'    => $order,
            'items'    => $items,
            'shipping' => $shipping,
            'banners'  => $banners,
            'response' => $response
        ]);
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
