<?php

namespace Modules\Shopping\Http\Controllers;


use App\Helpers\SessionHdl;
use App\Helpers\SessionRegisterHdl;
use App\Helpers\ShoppingCart;
use App\Helpers\RestWrapper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CommonMethods;
use Mockery\Exception;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\Language;
use Modules\Shopping\Entities\Bank;
use Modules\Shopping\Entities\Legal;
use Modules\Shopping\Entities\Order;
use Modules\Shopping\Entities\OrderDetail;
use Modules\Shopping\Entities\PromoProd;
use Modules\Shopping\Entities\SecurityQuestions;
use Modules\Shopping\Entities\ShippingAddress;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\ConfirmationBanner;
use Modules\Shopping\Http\Controllers\traits\Register;
use Carbon\Carbon;
use View;




class RegisterController extends Controller
{

    use Register;

    public function __construct()
    {
        $this->CommonMethods = new CommonMethods();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function register(Request $request)
    {

        //Generar Sesion para inscription


        //Validate if webservices are active
        if ( (config('settings::frontend.webservices') != 1  || !SessionRegisterHdl::isInscriptionActive()) && !allow_by_ip(\Request::ip())) {
            return redirect('/');
        }

        if(!isset($request->distributor_code) && SessionHdl::hasEo()){
            return Redirect::route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['register']), array('distributor_code' => Session::get('portal.eo.distId')));
        }


        $codEo = "";
        $numEo ="";
        $this->generateSession();



        Session::put('portal.request_businessman', false);

        if(count($request->all()) > 0){
            $numEo = !empty($request->distributor_code) ? $request->distributor_code : '';
            $codEo = 1;

            Session::put('portal.request_businessman', true);
        }


        $months = config('shopping.months');
        $countries = $this->CommonMethods->getCountries();
        $shoppingCart = ShoppingCart::getItems(SessionRegisterHdl::getCorbizCountryKey());
        $points = ShoppingCart::getPointsQuotation(SessionRegisterHdl::getCorbizCountryKey());
        $subtotal = ShoppingCart::getSubtotalFormattedQuotation(SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCurrencyKey());
        $currency  = Session::get('portal.main.currency_key');



        return View::make('shopping::frontend.register.register',['brand' => Session::get('portal.main.brand.name'),'countries' => $countries['data'],'months' => $months,'codEo' => $codEo,'numEo' => $numEo,'shoppingCart' => $shoppingCart,'currency' => $currency,'points' => $points,'subtotal' => $subtotal]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    /**
     * Genera la sesión para trabajar durante la inscripción para no afectar la sesión global
     * @param
     * @return
     */
    public function generateSession(){
        Session::put('portal.register.time_zone', Session::get('portal.main.time_zone'));
        Session::put('portal.register.webservice',Session::get('portal.main.webservice'));
        Session::put('portal.register.country_id',Session::get('portal.main.country_id'));
        Session::put('portal.register.currency_key',Session::get('portal.main.currency_key'));
        Session::put('portal.register.country_corbiz',Session::get('portal.main.country_corbiz'));
        Session::put('portal.register.language_id',Session::get('portal.main.language_id'));
        Session::put('portal.register.language_name',Session::get('portal.main.language_name'));
        Session::put('portal.register.language_corbiz',Session::get('portal.main.language_corbiz'));



    }

    /**
     * Actualiza los datos de la sesión de registro cuando cambia de país en el formulario.
     * @param  Request $request
     * @return $data
     */
    public function updateSession(Request $request){
        if ($request->ajax()) {
            $glob_country = Country::where(['id' => $request->country, 'active' => 1, 'delete' => 0])->first();

            if (!empty($glob_country)) {
                Session::forget('portal.register');
                Session::put('portal.register.time_zone', $glob_country->timezone);
                Session::put('portal.register.webservice', $glob_country->webservice);
                Session::put('portal.register.country_id', $glob_country->id);
                Session::put('portal.register.currency_key', $glob_country->currency_key);
                Session::put('portal.register.country_corbiz', $glob_country->corbiz_key);


                $lanDefault = Language::where('locale_key', '=', $glob_country->default_locale)->first();

                if ($lanDefault != null) {
                    Session::put('portal.register.language_id', $lanDefault->id);
                    Session::put('portal.register.language_name', $lanDefault->language_country);
                    Session::put('portal.register.language_corbiz', $lanDefault->corbiz_key);
                }


                return $data = array('country_name' => $glob_country->corbiz_key);

            }
        }


    }

    /**
     * Obtiene las referencias de registro de la base de datos.
     * @param  Request $request
     * @return Response
     */
    public function references(Request $request){
        if ($request->ajax()) {
            return $this->CommonMethods->getRegistrationReferences($request->country, Session::get('portal.register.language_corbiz'));
        }
    }

    public function legals(Request $request){
        if ($request->ajax()) {
            return $this->CommonMethods->getLegalDocuments($request->country, Session::get('portal.register.language_corbiz'));
        }
    }

    /**
     * Obtiene la información del pool de empresarios
     * @param  Request $request
     * @return Response
     */
    public function pool(Request $request){
        if ($request->ajax()) {
            return $this->CommonMethods->getPool($request->country, 'register');
        }
    }
    /**
     * Obtiene las preguntas de la clase de métodos comunes
     * @param  Request $request
     * @return Response
     */
    public function  questions(Request $request){
        if ($request->ajax()) {
            return $this->CommonMethods->getSecretQuestions($request->country);
        }
    }
    /**
     * valida si existes el empresario ingresado
     * @param  Request $request
     * @return Response
     */
    public function validateEo(Request $request){
        if ($request->ajax()) {
            return $this->CommonMethods->validateSponsorFromCorbiz(Session::get('portal.register.webservice'), Session::get('portal.register.country_corbiz'), $request->sponsor, Session::get('portal.register.language_corbiz'));
        }
     }
    /**
     * Obtiene los parametros de configuración del pais
     * @param  Request $request
     * @return Response
     */
    public function parameters(Request $request){
        if ($request->ajax()) {
            return $this->CommonMethods->getRegistrationParameters($request->country);
        }
    }
    /**
     * Obtiene los métodos de pago del pais
     * @param  Request $request
     * @return Response
     */
    public function banks(Request $request){
        if ($request->ajax()) {
            return $this->CommonMethods->getBanks($request->country);
        }
    }
    /**
     * Obtiene laos documentos correspondientes al país
     * @param  Request $request
     * @return Response
     */
    public function shippingCompanies(Request $request){
        if ($request->ajax()) {
            return $this->CommonMethods->getShippingCompaniesFromCorbiz(Session::get('portal.register.webservice'), Session::get('portal.register.country_corbiz'), Session::get('portal.register.language_corbiz'), $request->state, $request->city);
        }
    }

    /**
     * Obtiene los documentos correspondientes al país
     * @param  Request $request
     * @return Response
     */
    public function documents(Request $request){

        if ($request->ajax()) {
            return $this->CommonMethods->getDocumentsFromCorbiz(Session::get('portal.register.webservice'), Session::get('portal.register.country_corbiz'), Session::get('portal.register.language_corbiz'));
        }
     }

    public function kits(Request $request){
        if ($request->ajax()) {
            return $this->CommonMethods->getkitsInscription($request->country);
        }
    }



    /**
     * Incluye el formulario en base al pais seleccionado.
     * @param  Request $request
     * @return view
     */
     public function changeViews(Request $request){
         if ($request->ajax()) {
            try{

                $country = strtolower($request->country);


                    $view = 'shopping::frontend.register.includes.'.$country.'.form_'.$country;
                    if(View::exists($view)){
                        return view($view);
                    }




                return "";

            }catch (Exception $e){
                return "";
            }
         }

    }

    /**
     * Elimina de la sesión la transacción actual para que sea generada una nueva debido al cambio o eliminación de Items o información general en la inscripcion
     * @param  Request $request
     * @return array
     */
    public function flushRegisterTransaction(Request $request){
        if ($request->ajax()) {
            $response    = ['status' => false, 'data' => [], 'messages' => []];

            if(SessionRegisterHdl::hasTransaction()){

                Session::forget('portal.register.checkout.'.SessionRegisterHdl::getCorbizCountryKey().'.transaction');
                $response    = ['status' => true, 'data' => [], 'messages' => []];
            }

            Session::put('portal.register.step', 2);

            return $response;
        }

    }

    /**
     * Cambio de Step en sesion
     * @param  Request $request
     * @return array
     */
    public function backStep2(Request $request)
    {
        if ($request->ajax()) {
            Session::put('portal.register.step', 1);

            return [
                'status'    => true,
                'data'      => [],
                'messages'  => []
            ];
        }
    }




    /**
     * Valida los campos requeridos por cada paso del registro
     * @param  Request $request
     * @return
     */
    public function postValidateStep1(Request $request)
    {
        if ($request->ajax() && Session::has('portal.register'))
        {

            $key_messages = array();
            $value_messages = array();

            foreach (Config::get('shopping.register.messages.' . Session::get('portal.register.country_corbiz') . '.step1') as $keyMessage => $valueMessage)
            {
                $key_messages[] = $keyMessage;
                $value_messages[] = trans($valueMessage);
            }

            $key_labels = array();
            $value_labels = array();
            foreach (Config::get('shopping.register.labels.' . Session::get('portal.register.country_corbiz') . '.step1') as $keyLabel => $valueLabel)
            {
                $key_labels[] = $keyLabel;
                $value_labels[] = trans($valueLabel);
            }


            $rules = config('shopping.register.rules.' . Session::get('portal.register.country_corbiz') . '.step1');

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

            Session::put('portal.register.steps', $request->all());
            Session::put('portal.register.step', 2);

            return response()->json([
                'success'   => true,
                'message'   => '',
            ]);
        }else{
            return redirect('/register');
        }
    }

    /**
     * Valida los campos requeridos por cada paso del registro
     * @param  Request $request
     * @return
     */
    public function postValidateStep2(Request $request)
    {
        if ($request->ajax() && Session::has('portal.register'))
        {

            $key_messages = array();
            $value_messages = array();
            foreach (Config::get('shopping.register.messages.' . Session::get('portal.register.country_corbiz') . '.step2') as $keyMessage => $valueMessage)
            {
                $key_messages[] = $keyMessage;
                $value_messages[] = trans($valueMessage);
            }

            $key_labels = array();
            $value_labels = array();
            foreach (Config::get('shopping.register.labels.' . Session::get('portal.register.country_corbiz') . '.step2') as $keyLabel => $valueLabel)
            {
                $key_labels[] = $keyLabel;
                $value_labels[] = trans($valueLabel);
            }
            
            
            $rules = config('shopping.register.rules.' . Session::get('portal.register.country_corbiz') . '.step2');

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

            //Validar fecha de nacimiento correcta
            $bornDate = checkdate($request->get('month'), $request->get('day'), $request->get('year'));

            if ($bornDate == false) {
                return response()->json([
                    'success'   => false,
                    'message'   => [
                        'borndate'  => trans('shopping::register.account.borndate.alert'),
                    ],
                ]);
            }





            Session::put('portal.register.steps', $request->all());
            Session::put('portal.register.step', 3);

            //Obtención del almacen y centro de distribución test
            $warehouseinfo = $this->getWarehouseFromCorbiz($request);

            if($warehouseinfo['success']){
                Session::put('portal.register.steps.warehouse',$warehouseinfo['data']['warehouse']);
                Session::put('portal.register.steps.distCenter',$warehouseinfo['data']['distCenter']);
            }

            return response()->json([
                'success'   => $warehouseinfo['success'],
                'message'   => $warehouseinfo['message'],
                'result'    =>  ''
            ]);
        }
        else{
            return redirect('/register');
        }
    }

    /**
     * Valida los campos requeridos por cada paso del registro
     * @param  Request $request
     * @return
     */
    public function postValidateStep3(Request $request)
    {
        if ($request->ajax() && Session::has('portal.register'))
        {

            $key_messages = array();
            $value_messages = array();
            foreach (Config::get('shopping.register.messages.' . Session::get('portal.register.country_corbiz') . '.step2') as $keyMessage => $valueMessage)
            {
                $key_messages[] = $keyMessage;
                $value_messages[] = trans($valueMessage);
            }

            $key_labels = array();
            $value_labels = array();
            foreach (Config::get('shopping.register.labels.' . Session::get('portal.register.country_corbiz') . '.step2') as $keyLabel => $valueLabel)
            {
                $key_labels[] = $keyLabel;
                $value_labels[] = trans($valueLabel);
            }

            $rules = config('shopping.register.rules.' . Session::get('portal.register.country_corbiz') . '.step3');

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


            Session::put('portal.register.steps', $request->all());
            Session::put('portal.register.step', 4);


            return response()->json([
                'success'   => true,
                'message'   => '',
            ]);
        }else{
            return redirect('/register');
        }
    }



    /**
     * Obtiene los estados correspondientes al país
     * @param  Request $request
     * @return Response
     */
    public function states(Request $request){
        if ($request->ajax()) {
            return $this->CommonMethods->getStatesFromCorbiz(Session::get('portal.register.webservice'), Session::get('portal.register.country_corbiz'), Session::get('portal.register.language_corbiz'));
        }
    }
    /**
   * Obtiene las ciudades correspondientes al país y estado
   * @param  Request $request
   * @return Response
   */
    public function cities(Request $request){
        if ($request->ajax()) {
            return $this->CommonMethods->getCitiesFromCorbiz(Session::get('portal.register.webservice'), Session::get('portal.register.country_corbiz'), Session::get('portal.register.language_corbiz'), $request->state);
        }
    }

    public function zipcode(Request $request)
    {
        if ($request->ajax())
        {
            return $this->CommonMethods->getZipCodesFromCorbiz(Session::get('portal.register.webservice'), Session::get('portal.register.country_corbiz'), Session::get('portal.register.language_corbiz'), $request->zipCode);
        }
    }


    /**
     * Obtiene el warehouse correspondiente a la ciudad y estado
     * @return Response
     */
    public function getWarehouseFromCorbiz(Request $request){
            //validación para obter los parametros que recibe el serivico getAvailableWH
            $paramsWarehouse = $this->CommonMethods->getCountryConfiguration(SessionRegisterHdl::getRouteWS(), SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCorbizLanguage());


            if($paramsWarehouse['status']){

                $isUnique = $paramsWarehouse['WHUnique'];
                $idWH = isset($paramsWarehouse['idWH']) ? $paramsWarehouse['idWH'] : '';
                $stateKey = $paramsWarehouse['UseCity'] ? $request->state_hidden : '';
                $cityKey = $paramsWarehouse['UseCity'] ? $request->city_hidden : '';
                $zip = $paramsWarehouse['UseZipCode'] ? $request->zip : '';

                $result_wh  = $this->CommonMethods->getAvailableWH(SessionRegisterHdl::getRouteWS(), SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCorbizLanguage(), $stateKey, $cityKey,$zip);


                    if ($result_wh['success'] == true)
                    {
                        $response = [
                            'success'   => true,
                            'message'   => '',
                            'data' => $result_wh['message'],
                        ];

                    }
                    else
                    {
                        $response = [
                            'success'   => false,
                            'message'   => $result_wh['message'],
                            'data'      => ''
                        ];
                    }


            }else{
                $response = [
                    'success'   => false,
                    'message'   => trans('shopping::register.account.warehouse.emptyparams'),
                    'data'      => ''
                ];
            }


        return $response;
    }
    /**
     * Almacena en sesión la fecha y hora que se da click en aceptar terminos y condiciones
     * @param  Request $request
     * @return Response
     */
    public function checkedterms(Request $request){

        $date     = new \DateTime('now', new \DateTimeZone(SessionRegisterHdl::getTimeZone()));

        if ($request->ajax()) {
            $success = false;
            $message = trans('shopping::register.account.country.emptydata');
            $data = array();

            if (!empty($request->id)) {

                if($request->checkmarked == 'true'){

                    Session::put('portal.register.hour_' . $request->id,$date->format('Y-m-d H:i:s'));
                    $success = true;

                }else{

                    Session::forget('portal.register.hour_' . $request->id.'');
                    $success = true;
                }

                return ['success' => $success, 'message' => '', 'data' => $data];
            } else {
                return ['success' => $success, 'message' => $message, 'data' => $data];
            }
        }
    }

    public function setcompany(Request $request)
    {
        if ($request->ajax()) {
            $success = false;
            $message = trans('shopping::register.account.country.emptydata');
            $data = array();

            if (!empty($request->company)) {


                Session::put('portal.register.steps.shipping_way', $request->input('company'));
                $success = true;
                $message = '';
                return ['success' => $success, 'message' => $message, 'data' => $data];

            } else {
                return ['success' => $success, 'message' => $message, 'data' => $data];
            }
        }
    }




    /* * * Register - Modal Registro Inconcluso * * */
    public function postExit(Request $request)
    {
        if ($request->ajax())
        {
            /* Envio de Correo a Empresario */
            if (Session::has('portal.register.steps.email') && Session::has('portal.register.steps.name') && Session::has('portal.register.hour_terms2'))
            {
                $emailsSend = Config::get('cms.email_send');
                $from_email = $emailsSend[Session::get('portal.register.country_corbiz')];

                $data = [
                    'view_mail'         => 'shopping::frontend.register.includes.' . strtolower(Session::get('portal.register.country_corbiz')) . '.mails.prospect-register',
                    'from_email'        => $from_email,
                    'title'             => trans('shopping::register.mail.prospect.title'),
                    'to_email'          => Session::get('portal.register.steps.distributor_email'),
                    'name'              => Session::get('portal.register.steps.distributor_name'),
                    'subject'           => trans('shopping::register.mail.prospect.subject'),
                    'name_prospect'     => (empty(Session::get('portal.register.steps.lastname'))) ? Session::get('portal.register.steps.name') : Session::get('portal.register.steps.name') . ' ' . Session::get('portal.register.steps.lastname'),
                    'tel_prospect'      => Session::get('portal.register.steps.tel'),
                    'cel_prospect'      => Session::get('portal.register.steps.cel'),
                    'email_prospect'    => Session::get('portal.register.steps.email'),
                ];

                if (!empty($from_email) && !empty(Session::get('portal.register.steps.distributor_email')) && !empty(Session::get('portal.register.steps.name')))
                {
                    $this->CommonMethods->getSendMail($data);
                }
            }

            /* Variable para activar redireccionamiento de registro inconcluso */
            Session::put('portal.unfinished_register', true);

            return response()->json([
                'success'   => true,
                'message'   => url($request->url_next_exit_register),
            ]);
        }
    }

    /**
     * validateRegisterForm
     * Valida si los datos enviados en el formulario son validos para su registro
     *
     * TODO
     *
     * @param Request $request  Petición HTTP
     * @return array
     */
    public function validateFormCorbiz(Request $request) {

        $response = ['status' => false];

        if ($request->ajax()) {


            if (SessionRegisterHdl::hasSteps()) {
                $country = Country::find(SessionRegisterHdl::getCountryID());
                $formEntepreneur = $this->getWSFormEntepreneur();

                $docsEntepreneur = $this->getWSDocsEntepreneur();


                $responseWs = $this->CommonMethods->addFormEntrepreneur($country->webservice, SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCorbizLanguage(), $formEntepreneur, $docsEntepreneur);

                if ($responseWs['status']) {

                    $response['status'] = true;
                    $response['errors'] = '';

                    //$response = $this->processCorbizTransaction();
                } else {
                    $response['status'] = false;
                    $response['errors'] = $responseWs['messages'];
                    $response['details'] = $responseWs['err'];
                }
            }else{
                $response['status'] = false;
                $response['errors'] = "no se encontro sesión de steps";
            }

        }

        return $response;
    }

    public function  kitInitQuotation(Request $request){
        Session::forget('portal.register.'.SessionRegisterHdl::getCorbizCountryKey().'.promotionsItemsTemp');
        Session::forget("portal.register.".SessionRegisterHdl::getCorbizCountryKey().".promotionsSent");

        return $this->initQuotation($request);

    }

    public function getInitQuotationPromos(Request $request){
        return $this->initQuotation($request);
    }

    /*
 * initQuotation()
 * Inicia con el proceso de cotizacion
 *
 * Recibe Request, el cual contiene el kit seleccionado para cotizarlo
 * */
    public function initQuotation(Request $request){

        $steps = SessionRegisterHdl::getSteps();
        $resultValidateAvailableWH = false;
        $resultASW = false;
        $result = array();

        session()->forget('portal.register.'.SessionRegisterHdl::getCorbizCountryKey().'quotation');


            Session::put('portal.register.steps.kitselected',$request->kitselected);
            //Session::forget('portal.register.cart.'.SessionRegisterHdl::getCorbizCountryKey());

            $kitarr = ['kit'=> $request->kitselected,'kitprice' => $request->price,'kitid' => $request->kitid,'kitname' => $request->kitname,'kitdescription' => $request->kitdescription,'kitimage' => $request->kitimage,'iskit' => $request->iskit];
            //dd($request->all());
            if(!isset($request->fromChanged)){
                Session::put('portal.register.cart.'.SessionRegisterHdl::getCorbizCountryKey().'.items',$kitarr);
            }


            $countryKey = SessionRegisterHdl::getCorbizCountryKey();
            //validamos si existe cesta, si existe se invocan los métodos para la validar las existencias
            if(Session::has("portal.cart.{$countryKey}.items")){
                ShoppingCart::validateProductWarehouse(SessionRegisterHdl::getCorbizCountryKey(),Session::get('portal.register.steps.warehouse'));
                ShoppingCart::validateProductRestrictionState(SessionRegisterHdl::getCorbizCountryKey(), $steps['state_hidden']);
            }
            //procedemos al método de la cotización
            $resultASW = $this->getAddSalesWebWS($steps);


            if($resultASW['success']){

                $result = array(
                    'products' => ShoppingCart::getItems(SessionHdl::getCorbizCountryKey()),
                    'status' => true,
                    'messages' =>  '',
                    'resultASW' => $resultASW,

                );
            }else{

                $result = array(
                    'status' => false,
                    'messages' =>  $resultASW['response'],
                    'resultASW' => $resultASW,

                );
            }












        return $result;
    }


    /*
    public function getWarehouse(Request $request){

        $warehouse = $this->getWarehouseFromCorbiz($request->zip);

        if(isset($warehouse['data']['warehouse'])){

            $result = array(
                'status' => true,
                'messages' =>  '',
                'resultASW' => ['warehouse' => $warehouse['data']['warehouse'],'distCenter' => $warehouse['data']['distCenter']],

            );
        } else{
            $result = array(
                'status' => false,
                'messages' =>  trans("shopping::register.warehouse.empty"),
                'resultASW' => '',

            );
        }

        return $result;

    }
        */
    /**
     * processCorbizTransaction
     * Genera un numero de transacción en corbiz
     *
     * TODO
     *
     * @param Request $request  Petición HTTP
     * @return array
     */
    public function transactionFromCorbiz(Request $request) {

        $response = ['status' => false];
        $date     = new \DateTime('now', new \DateTimeZone(SessionRegisterHdl::getTimeZone()));


        if ($request->ajax()) {
            $paymentMethodId = $request->paymentMethod;

            if (!SessionRegisterHdl::hasPaymentMethod()) {
                Session::put('portal.register.checkout.'.SessionRegisterHdl::getCorbizCountryKey().'.paymentMethod', $paymentMethodId);
            }

            if (!SessionRegisterHdl::hasTransaction()) {

                if (SessionRegisterHdl::hasSteps()) {
                    $country = Country::find(SessionRegisterHdl::getCountryID());
                    $salesWeb = $this->getWSSalesWeb();      # Info para el servicio
                    $salesWebItems = $this->getWSSalesWebItems(); # Info para el servicio
                    //dd($salesWeb,$salesWebItems);

                    $responseWs = $this->CommonMethods->getTransactionFromCorbiz($country->webservice, SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCorbizLanguage(), $salesWeb, $salesWebItems);

                    if ($responseWs['status']) {
                        Session::put('portal.register.checkout.'.SessionRegisterHdl::getCorbizCountryKey().'.transaction', $responseWs['data']['transaction']);
                        $response = $this->saveInscriptionOrder();

                    } else {
                        $response['status'] = false;
                        $response['errors'] = $responseWs['messages'];
                    }
                }
            } else {

                if ($paymentMethodId != SessionRegisterHdl::getPaymentMethod()) {
                    Session::put('portal.register.checkout.'.SessionRegisterHdl::getCorbizCountryKey().'.paymentMethod', $paymentMethodId);
                    Order::where('corbiz_transaction', SessionRegisterHdl::getTransaction())->update(
                        [
                            'bank_id' => $paymentMethodId,
                            'updated_at' => $date->format('Y-m-d H:i:s')
                        ]);
                }


                if (!Order::exists('corbiz_transaction', SessionRegisterHdl::getTransaction())) {

                    $response = $this->saveInscriptionOrder();
                }
                else {

                    $response['status'] = true;
                }

            }


            # Regresamos a la vista la clave del método de pago y el número de orden

            $paymentMethod = Bank::find($paymentMethodId);
            $order         = Order::where('corbiz_transaction', SessionRegisterHdl::getTransaction())->first();


            if ($order != null) {
                $response['method_key'] = $paymentMethod->bank_key;
                $response['order']      = $order->order_number;
            }

        }

        return $response;
    }




    /**
     * getAddSalesWebWS
     * * @param Array $dataAddSalesWeb Contiene los datos necesarios para el WS y los productos del carrito formateados
     * @return mixed            Respuesta del WS
     */

    public function getAddSalesWebWS($steps = array(),$process = 'register') {

        $shoppingCartController = new ShoppingCartController();

        $defaultCodePaid = config('shopping.paymentCorbizRelation.' . SessionRegisterHdl::getCorbizCountryKey() . '.default');
        $arrayItems = $this->getItemsFormatedAddSalesWebWS($process);



        $dataASW = array(
            'dataAddress' => $steps,
            'arrayItems' => $arrayItems,
            'cartResume' => $shoppingCartController->getCartResume(),
            'codePaid' => config('shopping.paymentCorbizRelation.' . SessionRegisterHdl::getCorbizCountryKey() . '.' . $defaultCodePaid)
        );

        $restWrapper = new RestWrapper(SessionRegisterHdl::getRouteWS()."addSalesWeb");
        $params = ['request' => [
            'CountryKey' => SessionRegisterHdl::getCorbizCountryKey(),
            'Lang' => SessionRegisterHdl::getCorbizLanguage(),
            'SalesWeb' => [
                'ttSalesWeb' => [
                    [
                        'countrysale' => SessionRegisterHdl::getCorbizCountryKey(),
                        'no_trans' => '',
                        'distributor' =>  '',
                        'amount' => 70,
                        'receiver' => isset($dataASW['dataAddress']['name']) ? $dataASW['dataAddress']['name'] : '',
                        'address' => isset($dataASW['dataAddress']['street']) ? $dataASW['dataAddress']['street'] : '',
                        'number' => '',
                        'suburb' => '',
                        'complement' => isset($dataASW['dataAddress']['betweem_streets']) ? $dataASW['dataAddress']['betweem_streets'] : '',
                        'state' => isset($dataASW['dataAddress']['state_hidden']) ? $dataASW['dataAddress']['state_hidden'] : '',
                        'city' => isset($dataASW['dataAddress']['city_hidden']) ? $dataASW['dataAddress']['city_hidden'] : '',
                        'county' => isset($dataASW['dataAddress']['colony']) ? $dataASW['dataAddress']['colony'] : '',
                        'zipcode' => isset($dataASW['dataAddress']['zip']) ? $dataASW['dataAddress']['zip'] : '',
                        'shippingcompany' => isset($dataASW['dataAddress']['shipping_way']) ? $dataASW['dataAddress']['shipping_way'] : '',//obtener de la sesión,
                        'altAddress' => 0,
                        'email' => isset($dataASW['dataAddress']['email']) ? $dataASW['dataAddress']['email'] : '',
                        'phone' => isset($dataASW['dataAddress']['tel']) ? $dataASW['dataAddress']['tel'] : '',
                        'previousperiod' => false,
                        'source' => 'WEB',
                        'type_mov'=> 'INGRESA',
                        'codepaid' => isset($dataASW['codePaid']) ? $dataASW['codePaid'] : '',
                        'zcreate' => false
                    ]
                ],
            ],
            'SalesWebItems' => [
                'ttSalesWebItems' => $dataASW['arrayItems']
            ]
        ]];

        $resultQuoteWeb = $restWrapper->call("POST",$params,'json', ['http_errors' => false]);

        $resultData = $this->getResultDataAddSalesWeb($resultQuoteWeb);


        if($resultData['requotation']){
            return $this->getAddSalesWebWS($steps);
        } else {
            //Eliminado de la session de los Items temporales de Promociones
            //SessionRegisterHdl::forgetPromotionItems();
            $arrayItems = $this->getItemsFormatedAddSalesWebWS($process);
            //Validacion para que en caso de que la cotizacion no lleve productos, retorne false salga del proceso de cotizacion
            if(count($arrayItems) == 1 && $arrayItems[0]['kitinscr'] == "yes"){
                //dd($arrayItems);
                SessionHdl::forgetMessageErrorSW();

            }
            $resultData['viewErrors'] = $this->getResumeCartViewErrors();

            return $resultData;
        }
    }

    /**
     * getResumeCartViewErrors
     *
     * @return mixed    Vista renderizada de los errores de la cotizacion
     */
    public function getResumeCartViewErrors() {
        $viewErrors = "";
        if(View::exists("shopping::frontend.register.includes.resume_quotation_errors")) {
            $viewErrors = View::make("shopping::frontend.register.includes.resume_quotation_errors");
        }
       return (string)$viewErrors;
    }



    /**
     * getResultDataAddSalesWeb
     *
     * @param String $corbizKey Llave CorBiz del país
     * @return mixed            Vista renderizada de los métodos de pago
     */
    public function getResultDataAddSalesWeb($responseWS){

        $dataResult = array();

        if($responseWS['success'] && $responseWS['responseWS']['response']['Success'] == 'true')
        {
            //cotizacion exitosa
            Register::setSessionCartAddSalesWeb($responseWS['responseWS']['response']);
            $dataResult['success'] = true;
            $dataResult['requotation'] = false;
            $dataResult['response'] = $responseWS['responseWS']['response'];
            $dataResult['existsPromotions'] = false;
            $process = 'register';
            $dataResult['details'] = "";
            if(session()->exists('delete-items')){
                SessionHdl::forgetMessageErrorSW();
            }
            //Armado de arreglo de promociones
            if(isset($responseWS['responseWS']['response']['HedPromo']['dsHedPromo']['thedPromo'])
                && isset($responseWS['responseWS']['response']['DetPromo']['dsDetPromo']['tdetPromo'])){
                $promotionController = new PromotionController();
                $dataResult['existsPromotions'] = $promotionController->initPromotions($responseWS['responseWS']['response']['HedPromo']['dsHedPromo']['thedPromo']
                    ,$responseWS['responseWS']['response']['DetPromo']['dsDetPromo']['tdetPromo'], $process );
            }


            $dataResult['view'] = $this->getResumeCartViewAfterQuotation();

            return $dataResult;
        }
        else if(!$responseWS['success']  && isset($responseWS['responseWS']['response']['Success']) == 'false' && isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])){

            $requotation = ShoppingCart::removeItemsCartAddSalesWebWS($responseWS['responseWS']['response']['Error']['dsError']['ttError']);

            //Detalles de la respuesta para modal de más detalles
            $details = [];

            foreach ($responseWS['responseWS']['response']['Error']['dsError']['ttError'] as $key => $value)
            {
                $details[] = [
                    'err_code' => $value['idError'],
                    'err_msg' => $value['messUser'],
                    'err_tech' => $value['messTech'],
                ];
            }


            $dataResult['success'] = false;
            $dataResult['requotation'] = $requotation;
            $dataResult['response'] = $responseWS['responseWS']['response']['Error']['dsError']['ttError'];
            $dataResult['details'] = $details;
            $dataResult['hidePayment'] = $requotation ? false : true;

            //Si el error devuelto por el WS es debido a un producto no diponible, no se pinta el mensaje de error de corbiz
            if(isset($dataResult['response'])) {

                $errors = [];
                foreach ($dataResult['response'] as $rsp){
                    $errors[] = $rsp['messUser'];
                }

                session()->flash('message-error-sw', $errors);

                //$dataResult['viewErrors'] = $this->getResumeCartViewErrors();
            }

            //dd(session()->get('message-error-sw'));



            return $dataResult;
            //dd($resultQuoteWeb['responseWS']['response']['Error']['dsError']['ttError']);
        }else{


            $details = [];
            //Si el error devuelto por el WS es debido a un producto no diponible, no se pinta el mensaje de error de corbiz
            if(isset($responseWS['message'])) {
                //Detalles de la respuesta para modal de más detalles
                $details = [
                    'err_code' => 500,
                    'err_msg'  => $responseWS['message'],
                    'err_tech' => $responseWS['message'],
                ];
                session()->flash('message-error-sw', $responseWS['message']);
                //$dataResult['viewErrors'] = $this->getResumeCartViewErrors();
            } else {
                //Aquí va el flujo de varios mensajes de error del WS
                $errors = [];
                foreach ($dataResult['response'] as $rsp){
                    $errors[] = $rsp['messUser'];
                }

                session()->flash('message-error-sw', $errors);
            }

            dd(session()->get('message-error-sw'));

            //errores no controlados excepciones
            $dataResult['success'] = false;
            $dataResult['requotation'] = false;
            $dataResult['details'] = $details;
            $dataResult['response'] = $responseWS['message'];





            return $dataResult;
            //dd($resultQuoteWeb['message']);
        }
    }

    /**
     * getResumeCartViewAfterQuotation
     *
     * @return mixed    Vista renderizada del resumen de compra
     */
    public function getResumeCartViewAfterQuotation() {

        $arrayViews = array('items' => "", 'totals' => "" );
        $corbizCountry      = strtolower(SessionRegisterHdl::getCorbizCountryKey());
        if(View::exists("shopping::frontend.register.includes.{$corbizCountry}.cart_preview_items_{$corbizCountry}")) {
            $viewItems = View::make("shopping::frontend.register.includes.{$corbizCountry}.cart_preview_items_{$corbizCountry}",
                [
                    'currency' => SessionRegisterHdl::getCurrencyKey(),
                    'shoppingCart' => Register::getItemsQuotation(SessionRegisterHdl::getCorbizCountryKey()),
                ]
            );
            $arrayViews['items'] = (string)$viewItems;
        }
        if(View::exists("shopping::frontend.register.includes.{$corbizCountry}.cart_preview_resume_{$corbizCountry}")) {
            $viewTotals = View::make("shopping::frontend.register.includes.{$corbizCountry}.cart_preview_resume_{$corbizCountry}",
                [
                    'currency' => SessionRegisterHdl::getCurrencyKey(),
                    'points' => Register::getPointsQuotation(SessionRegisterHdl::getCorbizCountryKey()),
                    'subtotal' => Register::getSubtotalFormattedQuotation(SessionRegisterHdl::getCorbizCountryKey(), SessionHdl::getCurrencyKey()),
                    'discount' => Register::getDiscountFormattedQuotation(SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCurrencyKey()),
                    'handle' => Register::getHandlingFormattedQuotation(SessionRegisterHdl::getCorbizCountryKey(), SessionHdl::getCurrencyKey()),
                    'taxes' => Register::getTaxesFormattedQuotation(SessionRegisterHdl::getCorbizCountryKey(), SessionHdl::getCurrencyKey()),
                    'total' => Register::getTotalFormattedQuotation(SessionRegisterHdl::getCorbizCountryKey(), SessionHdl::getCurrencyKey()),
                ]
            );

            $arrayViews['totals'] = (string)$viewTotals;
        }
        //dd($arrayViews);
        return $arrayViews;
       /*  $corbizCountry      = strtolower(SessionRegisterHdl::getCorbizCountryKey());
        if(View::exists("shopping::frontend.register.includes.{$corbizCountry}.cart_preview_{$corbizCountry}")) {
            return View::make("shopping::frontend.register.includes.{$corbizCountry}.cart_preview_{$corbizCountry}",
                [   'currency' => SessionRegisterHdl::getCurrencyKey(),
                    'shoppingCart' => Register::getItemsQuotation(SessionRegisterHdl::getCorbizCountryKey()),
                    'points' => Register::getPointsQuotation(SessionRegisterHdl::getCorbizCountryKey()),
                    'subtotal' => Register::getSubtotalFormattedQuotation(SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCurrencyKey()),
                    'handle' => Register::getHandlingFormattedQuotation(SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCurrencyKey()),
                    'taxes' => Register::getTaxesFormattedQuotation(SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCurrencyKey()),
                    'total' => Register::getTotalFormattedQuotation(SessionRegisterHdl::getCorbizCountryKey(), SessionRegisterHdl::getCurrencyKey())]
            );
        } else {
            return false;
        } */
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
        $items = SessionRegisterHdl::getKitInfo();

        foreach(ShoppingCart::getItems(SessionRegisterHdl::getCorbizCountryKey()) as $index => $isc){
            $arrayItems[] = [
                'numline' => $count,
                'countrysale' => SessionRegisterHdl::getCorbizCountryKey(),
                'item' => $isc['sku'],
                'quantity ' => $isc['quantity'],
                'listPrice' => $isc['price'],
                'discPrice' => '',
                'points' => $isc['points'],
                'promo' => false
            ];
            $count++;
        }

        //Se realiza el push para agregar el kit seleccionado para cotizarlo junto con los itemes en dado caso de un pedido combinado
        //Si solo viene el kit lo coloca en el array individualmente

         if(SessionRegisterHdl::hasPromotionItems($process)){
            foreach(ShoppingCart::getPromotionItems(SessionRegisterHdl::getCorbizCountryKey(), $process) as $index => $promotion){
                foreach($promotion as $isc){
                    $isc['numline'] = $count;
                    $arrayItems[] = $isc;
                    $count++;
                }
            }
        }
        $arrayItems[] = [
            'numline' => $count == 0 ? 1 : $count,
            'countrysale' => SessionRegisterHdl::getCorbizCountryKey(),
            'item' => $items['kit'],
            'quantity ' => 1,
            'listPrice' => $items['kitprice'],
            'discPrice' => '',
            'points' => 0,
            'promo' => false,
            'kitinscr' => 'yes'
        ];




        return $arrayItems;
    }



    public function confirmation(Request $request){

        //Validacioón de que se recibieron datos para procesar la orden
        if (!empty($request->data)) {
            $orderInfo = $this->obtainOrderData($request->data);

            $countryInfo = $this->getCountryInfo($orderInfo['order']['country_id']);
            $lanDefault = Language::where('locale_key', '=', $orderInfo['order']->country->default_locale)->first();
            $date = new \DateTime('now', new \DateTimeZone($countryInfo['timezone']));
            //Si se encuentran los datos en la BD  se procede a armar los llamados a los websevices
            if(!empty($orderInfo)){
                //Datos para llenar del formulario de empresario obtenidos de la DB
                $formEntepreneur = $this->getWSFormEntepreneur(true,true,$orderInfo);
                $docsEntepreneur = $this->getWSDocsEntepreneur('obtain',$orderInfo['order']['id'],$orderInfo['order']['corbiz_transaction'],$orderInfo['order']->country->corbiz_key);
                //Datos para registrar el pedido en corbiz



                //Grabamos en las tablas de corbiz los datos del Eo
                $saveDataEo = $this->CommonMethods->addFormEntrepreneur($countryInfo['webservice'], $countryInfo['corbiz_key'], $lanDefault->corbiz_key, $formEntepreneur, $docsEntepreneur);


                if ($saveDataEo['status']) {

                    //Se actualiza la DB para informar que el proceso de guardar la información en corbiz concluyó con éxito
                    Order::where('order_number', $orderInfo['order']->order_number)->update([
                        'saved_dataeo' => 1,
                        'updated_at' => $date->format('Y-m-d H:i:s'),
                    ]);
                    //Si es correcta la grabación de los datos invocamos el servicio para crear el empresario
                    $createEo = $this->CommonMethods->addEntrepreneur($countryInfo['webservice'], $countryInfo['corbiz_key'], $lanDefault->corbiz_key, $orderInfo['order']['corbiz_transaction']);

                    if($createEo['status']){

                        //actualización a order con el distributor number
                        Order::where('id',$orderInfo['order']->id)->update([
                            'distributor_number' => $createEo['data']['eonumber'],
                            'updated_at' => $date->format('Y-m-d H:i:s'),
                        ]);

                          //Actualización de base de datos para colocar el nuevo numero de empresario
                          ShippingAddress::where('order_id',$orderInfo['order']->id)->update([
                              'eo_number' => $createEo['data']['eonumber'],
                              'updated_at' => $date->format('Y-m-d H:i:s'),
                          ]);

                        $emailsSend = Config::get('cms.email_send');
                        $from_email = '';

                        foreach ($emailsSend as $countryCorbiz => $email)
                        {
                            if ($countryCorbiz == $countryInfo['corbiz_key'])
                            {
                                $from_email = $email;
                            }
                        }
                        //Envio de Mail al sponsor
                            $data_sponsor   = [
                                'view_mail'         => 'shopping::frontend.register.includes.'.strtolower($orderInfo['order']->country->corbiz_key).'.mails.sponsor',
                                'from_email'        => $from_email,
                                'title'             => trans('shopping::register.mail.sponsor.title'),
                                'to_email'          => $orderInfo['shippingAddress']['sponsor_email'],//'alan.magdaleno@omnilife.com',
                                'name'              => $orderInfo['shippingAddress']['sponsor_name'],
                                'subject'           => trans('shopping::register.mail.sponsor.subject',['name_sponsor' => $orderInfo['shippingAddress']['sponsor_name']]),
                                'name_customer'     => $orderInfo['shippingAddress']['eo_name'] . ' ' . $orderInfo['shippingAddress']['eo_lastname'],
                                'code_customer'     => $createEo['data']['eonumber'],
                                'tel_customer'      => isset($orderInfo['shippingAddress']['telephone']) ? $orderInfo['shippingAddress']['telephone'] : $orderInfo['shippingAddress']['cellphone'],
                                'email_customer'    => $orderInfo['shippingAddress']['email']
                            ];

                            if (($from_email != null || $from_email != '') && ($orderInfo['shippingAddress']['sponsor_email'] != '' || $orderInfo['shippingAddress']['sponsor_email'] != null))
                        {
                            $this->CommonMethods->getSendMail($data_sponsor);
                        }
                        //Envio de Mail al sponsor


                        $eo    = Crypt::encryptString(SessionHdl::getCorbizCountryKey().' '.SessionHdl::getCorbizLanguage().' '.$createEo['data']['eonumber'].' '.$createEo['data']['password']);
                        $legal = Legal::where('country_id', $orderInfo['order']->country_id)->whereTranslation('locale', $lanDefault->locale_key)->first();

                        //Envio de mail al nuevo empresario
                            $data_customer  = [
                                'view_mail'     => 'shopping::frontend.register.includes.'.strtolower($orderInfo['order']->country->corbiz_key).'.mails.customer',
                                'from_email'    => $from_email,
                                'title'         => trans('shopping::register.mail.customer.title'),
                                'to_email'      => $orderInfo['shippingAddress']['email'],//$orderInfo['shippingAddress']['email'],
                                'name'          => $orderInfo['shippingAddress']['eo_name'] . ' ' . $orderInfo['shippingAddress']['eo_lastname'],
                                'subject'       => trans('shopping::register.mail.customer.subject'),
                                'code'          => $createEo['data']['eonumber'],
                                'password'      => $createEo['data']['password'],
                                'question'      => $createEo['data']['question'],
                                'answer'        => $orderInfo['shippingAddress']['answer'],
                                'name_sponsor'  => $orderInfo['shippingAddress']['sponsor_name'],
                                'email_sponsor' => $orderInfo['shippingAddress']['sponsor_email'],
                                'url_login'     => '/login?eo=' . $eo,
                                'disclaimer'    => !is_null($legal) && $legal->active_disclaimer == 1 && !empty($legal->disclaimer_html) ? $legal->disclaimer_html : '',
                            ];

                            # Generación del código QR
                            $content = "date={$orderInfo['order']->terms_checked}&ip={$orderInfo['shippingAddress']['public_ip']}&country={$orderInfo['order']->country->name}&distributor={$createEo['data']['eonumber']}";
                            $qrInfo  = $this->getQRContractInfo($content);

                            # Generación del contrato
                            try {
                                $today = explode('.', date('d.m.y'));
                                $paths = $this->generateContract([
                                    'name'       => (!empty($orderInfo['shippingAddress']['eo_lastnamem']) ? "{$orderInfo['shippingAddress']['eo_lastname']} {$orderInfo['shippingAddress']['eo_lastnamem']}, " : "{$orderInfo['shippingAddress']['eo_lastname']}, ") . "{$orderInfo['shippingAddress']['eo_name']} ({$createEo['data']['eonumber']})",
                                    'address'    => $orderInfo['shippingAddress']['address'],
                                    'city'       => $orderInfo['shippingAddress']['city'],
                                    'state'      => $orderInfo['shippingAddress']['state'],
                                    'zipCode'    => $orderInfo['shippingAddress']['zip_code'],
                                    'birthday'   => date('m-d-Y', strtotime($orderInfo['shippingAddress']['birthdate'])),
                                    'email'      => $orderInfo['shippingAddress']['email'],
                                    'phone'      => isset($orderInfo['shippingAddress']['telephone']) ? $orderInfo['shippingAddress']['telephone'] : '',
                                    'cellphone'  => isset($orderInfo['shippingAddress']['cellphone']) ? $orderInfo['shippingAddress']['cellphone'] : '',
                                    'otherphone' => '',
                                    'dd'         => $today[0],
                                    'mm'         => $today[1],
                                    'yy'         => $today[2],
                                    'filename'   => $createEo['data']['eonumber'] . '.pdf'
                                ], $orderInfo['order']->country_id, $orderInfo['order']->country->default_locale, $qrInfo);
                                if ($paths !== false) {
                                    $data_customer['attachPdf']  = $paths['completePath'];

                                    Order::where('id', $orderInfo['order']->id)
                                        ->update([
                                            'contract_path' => $paths['publicPath'],
                                            'updated_at'    => $date->format('Y-m-d H:i:s')
                                        ]);
                                }
                            } catch (\ErrorException $e) {
                                Log::error('ERR Register (confirmation): ' . $e->getMessage());
                            }


                            if (($from_email != null || $from_email != '') && ($orderInfo['shippingAddress']['email'] != '' ||$orderInfo['shippingAddress']['email'] != null))
                            {
                                $this->CommonMethods->getSendMail($data_customer);
                            }

                                    //Inicio llamada addsalesweb para almacenar en la DB
                                    $salesWeb = $this->getWSSalesWeb(true,true,$orderInfo,$createEo['data']['eonumber']);
                                    $salesWebItems = $this->getWSSalesWebItems(true,$orderInfo);
                                    $responseWs = $this->CommonMethods->getOrderFromCorbiz($countryInfo['webservice'], $countryInfo['corbiz_key'], $lanDefault->corbiz_key, $salesWeb, $salesWebItems);

                                    //Si se procesa correctame el addSaleWeb

                                        if ($responseWs['status']) {

                                            Order::where('order_number',$orderInfo['order']->order_number)->update([
                                                'order_estatus_id'    => $this->CommonMethods->getOrderStatusId('ORDER_COMPLETE', $orderInfo['order']->country_id),
                                                'corbiz_order_number' => $responseWs['data']['order']
                                            ]);

                                            # Email de confirmación de la orden
                                            $data_order  = [
                                                'view_mail'     => 'shopping::frontend.register.includes.'.strtolower($orderInfo['order']->country->corbiz_key).'.mails.payment_success_order_corbiz',
                                                'from_email'    => $from_email,
                                                'title'         => trans('shopping::register.mail.order.title'),
                                                'to_email'      => $orderInfo['shippingAddress']['email'],//$orderInfo['shippingAddress']['email'],
                                                'name'          => $orderInfo['shippingAddress']['eo_name'] . ' ' . $orderInfo['shippingAddress']['eo_lastname'],
                                                'subject'       => trans('shopping::checkout.confirmation.emails.order_success'),
                                                'order'         => $responseWs['data']['order'],
                                                'address'       => $orderInfo['shippingAddress']['address'].' '.$orderInfo['shippingAddress']['city_name'].' '.$orderInfo['shippingAddress']['state'],
                                                'items'         => $this->getItemsToMail($orderInfo['order']->id),
                                                'detail'        => $this->getOrderDetail($orderInfo['order']->id)
                                            ];

                                           /*  $question = $createEo['data']['question'];*/
                                            $password = $createEo['data']['password'];
                                            $securityQuestion = SecurityQuestions::find($orderInfo['shippingAddress']['security_question_id']);
                                            $question = $securityQuestion->name;


                                            $this->CommonMethods->getSendMail($data_order);
                                            return $this->confirmationSuccess($responseWs,$orderInfo,'success',$question,$password);

                                        }
                                        //Si hay algun error en corbiz se almacena en la BD y se actualiza estatus
                                        else {

                                            $question = $createEo['data']['question'];
                                            $password = $createEo['data']['password'];

                                            Order::where('order_number', $orderInfo['order']->order_number)->update([
                                                'order_estatus_id'   => $this->CommonMethods->getOrderStatusId('CORBIZ_ERROR', $orderInfo['order']['country_id']),
                                                'updated_at'         => $date->format('Y-m-d H:i:s'),
                                                'error_user'         => $responseWs['err_order']['error_user'],
                                                'error_corbiz'       => $responseWs['err_order']['error_corbiz']
                                            ]);

                                            return $this->confirmationSuccess($responseWs,$orderInfo,'error',$question,$password,'createEo');

                                        }





                    }
                    //Actualización de base de datos si no se generó el empresario
                    else{


                        Order::where('order_number', $orderInfo['order']->order_number)->update([
                            'order_estatus_id'   => $this->CommonMethods->getOrderStatusId('CORBIZ_ERROR', $orderInfo['order']['country_id']),
                            'updated_at'         => $date->format('Y-m-d H:i:s'),
                            'error_user'         => $createEo['err_order']['error_user'],
                            'error_corbiz'       => $createEo['err_order']['error_corbiz']
                        ]);

                        return $this->confirmationSuccess($createEo,$orderInfo,'error','','','saveData');

                    }

                }
                else {
                    //Actualización de base de datos si no se guardaron los datos en las tablas de corbiz
                    $errorUser = isset($saveDataEo['messages'][0]['messUser']) ? $saveDataEo['messages'][0]['messUser'] : $saveDataEo['messages'][0];
                    $errorTech = isset($saveDataEo['messages'][0]['messTech']) ? : $saveDataEo['messages'][0];
                    Order::where('order_number', $orderInfo['order']->order_number)->update([
                        'order_estatus_id'   => $this->CommonMethods->getOrderStatusId('CORBIZ_ERROR', $orderInfo['order']['country_id']),
                        'updated_at'         => $date->format('Y-m-d H:i:s'),
                        'error_user'         => $errorUser,
                        'error_corbiz'       => $errorTech
                    ]);

                    return $this->confirmationSuccess($saveDataEo,$orderInfo,'error','','','saveData');


                }



            }else{
                //redirect a register por no encontraron datos en la db
                return redirect('/register');
            }


        }
        //redirect a register por no recibir datos mediante el request
         else {
             return redirect('/');
         }
    }


    private function confirmationSuccess($response,$info,$type = 'success',$question = '',$password = '',$step='') {
        $countryKey = $info['order']->country->corbiz_key;

        $order      = [];

        $order['type']     = $type;
        $order['order']    = Order::where('corbiz_transaction', $info['order']['corbiz_transaction'])->first();
        $order['items']    = OrderDetail::where('order_id', $order['order']->id)->get();
        $order['shipping'] = ShippingAddress::where('order_id', $order['order']->id)->first();
        $order['question'] = $question;
        $order['password'] = $password;
        $typebanner = 'success';
        # Tipo de vista
        if ($order['order']->order_estatus_id == $this->CommonMethods->getOrderStatusId('PAYMENT_PENDING', $info['order']['country_id'])) {
            $order['type'] = 'pending';
            $typebanner = 'warning';
        } else if ($order['order']->order_estatus_id == $this->CommonMethods->getOrderStatusId('CORBIZ_ERROR', $info['order']['country_id'])) {
            #validaciones para determinar a que vista se va y con que banner
            switch ($step){
                case 'saveData':
                    $typebanner = 'error';
                    $type = 'error';
                    break;
                case 'createEo':
                    $typebanner = 'success';
                    $type = 'no_order';
                    break;
                case 'saveOrder':
                    $typebanner = 'success';
                    $type = 'success';
                    break;
                default:
                    $typebanner = 'success';
            }

            $order['errors'] = $response['messages'];
        }

        foreach ($order['items'] as $i => $item) {
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

            $order['items'][$i]->name = $name;
            $order['items'][$i]->sku  = $sku;
        }

        Session::forget("portal.register");
        ShoppingCart::deleteSession($countryKey);

        $banners = $this->getBanners($typebanner,'inscription',$info['order']['country_id'],SessionRegisterHdl::getBrandID());


        $countryKey = strtolower($countryKey);

        return View::make("shopping::frontend.register.includes.{$countryKey}.payment.confirmation.confirmation", [
            'type'     => $type,
            'order'    => $order,
            'banners'  => $banners,
            'response' => $response
        ]);





    }





    public function obtainOrderData($data = array()){
        $order = $data['order'];
        $orderData = array();

        if(isset($order['bank_id'])){
            switch ($order['bank_id']){
                //Caso paypal
                case 1:
                    $orderInfo = Order::where('bank_transaction',$order['bank_transaction'])->first();
                    if($orderInfo != null){
                        $orderDetail = $orderInfo->orderDetail;
                        $shippingInformation = $orderInfo->shippingAddress;
                        $orderData = ['order' => $orderInfo,'orderDetail' => $orderDetail,'shippingAddress' => $shippingInformation];
                    }
                    break;
                //paypalplus
                case 2 :
                    $orderInfo = Order::where('bank_transaction',$order['bank_transaction'])->first();
                    if($orderInfo != null){
                        $orderDetail = $orderInfo->orderDetail;
                        $shippingInformation = $orderInfo->shippingAddress;
                        $orderData = ['order' => $orderInfo,'orderDetail' => $orderDetail,'shippingAddress' => $shippingInformation];
                    }
                break;
            }
        }



        return $orderData;


    }

    public function getCountryInfo($country){
        $data = [];
        $globCountries = Country::find($country);

        if(!is_null($globCountries)){

            $data = ['corbiz_key' => $globCountries['corbiz_key'],'webservice' => $globCountries['webservice'],'timezone' => $globCountries['timezone'],'currency_key' => $globCountries['currency_key']];

         }


        return $data;
    }

    private function generateContract($data, $countryId, $lang, $qrInfo) {
        $coords = Config::get('shopping.pdf.coords.'.SessionHdl::getCorbizCountryKey());
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

    private function getQRContractInfo($content) {
        $qrContractConfig = Config::get('shopping.pdf.qr.'.SessionHdl::getCorbizCountryKey());

        if ($qrContractConfig['has']) {
            return [
                'content' => $content,
                'img' => [
                    'x' => $qrContractConfig['img']['x'],
                    'y' => $qrContractConfig['img']['y'],
                    'w' => $qrContractConfig['img']['w']
                ],
                'txt' => [
                    'x' => $qrContractConfig['txt']['x'],
                    'y' => $qrContractConfig['txt']['y']
                ]
            ];
        }

        return false;
    }

    public function validateStreet(Request $request){
        $response = ['passes' => false,'message' => trans('shopping::register.info.address.street_message')];
        if($request->ajax() && !empty($request->street)){

            $hasRestricteds = str_contains(strtoupper($request->street),config('shopping.validation_po_box'));
            if($hasRestricteds){
                $response = ['passes' => false,'message' => trans('shopping::register.info.address.street_message_fail')];
            }else{
                $response = ['passes' => true,'message' => trans('shopping::register.info.address.street_message')];
            }
        }

        return $response;

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
