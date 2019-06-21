<?php

namespace App\Helpers;
use App\Helpers\RestWrapper;
use App\Helpers\SoapWrapper;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\DistributorsPool;
use Modules\Shopping\Entities\Bank;
use Modules\Shopping\Entities\Order;
use Modules\Shopping\Entities\OrderEstatus;
use Modules\Shopping\Entities\RegistrationReferences;
use Modules\Shopping\Entities\SecurityQuestions;
use Modules\Shopping\Entities\RegistrationParameters;
use Modules\Shopping\Entities\Legal;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\Product;
use Modules\Admin\Entities\Language;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Modules\Shopping\Entities\WarehouseCountry;

class CommonMethods{

    /*LLamado a servicios web*/
    /**
     * getStatesFromCorbiz
     * Realiza la petición del método getState a corbiz y se formatea su respuesta
     *
     * @param $ws           URL del webservice
     * @param $countryKey   Clave del país de corbiz
     * @param $lang         Clave del idioma de corbiz
     * @return array        Respuesta de la petición
     */
    public function getStatesFromCorbiz($ws, $countryKey, $lang) {
        $response    = ['status' => false, 'data' => [], 'messages' => []];
        $restWrapper = new RestWrapper("{$ws}getState?CountryKey={$countryKey}&Lang={$lang}");
        $responseWS  = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['State']['dsState']['ttState'])) {
            $response['status'] = true;
            foreach ($responseWS['responseWS']['response']['State']['dsState']['ttState'] as $state) {
                $response['data'][] = ['id' => trim($state['idState']), 'name' => trim($state['stateDescr'])];
            }

        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [
                    $responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser'],
                    '<i>'.$responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messTech'].'</i>'
                ];
            } else {
                if (isset($responseWS['message'])) {
                    $response['messages'] = [$responseWS['message']];
                } else {
                    $response['messages'] = [trans('shoppin::zip.errors.404')];
                }
            }
        }

        return $response;
    }


    public function validateSponsorFromCorbiz($ws, $countryKey, $sponsor, $lang) {


        $response    = ['status' => false, 'data' => [], 'messages' => []];
        $restWrapper = new RestWrapper("{$ws}validateSponsor?CountryKey={$countryKey}&Lang={$lang}&SponsorId={$sponsor}");

        $responseWS  = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['Sponsor']['dsSponsor']['ttSponsor'])) {
            $response['status'] = true;
            $response['data']   = [
                'dist_id' => trim($responseWS['responseWS']['response']['Sponsor']['dsSponsor']['ttSponsor'][0]['dist_id']),
                'name_1'  => trim($responseWS['responseWS']['response']['Sponsor']['dsSponsor']['ttSponsor'][0]['name1']),
                'name_2'  => trim($responseWS['responseWS']['response']['Sponsor']['dsSponsor']['ttSponsor'][0]['name2']),
                'email'   => trim($responseWS['responseWS']['response']['Sponsor']['dsSponsor']['ttSponsor'][0]['email']),
            ];
        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [

                    trim($responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser']),

                ];
            } else {
                if (isset($responseWS['message'])) {
                    $response['messages'] = [$responseWS['message']];
                } else {
                    $response['messages'] = [trans('shoppin::zip.errors.404')];
                }
            }
        }

        return $response;
    }


    public function getDocumentsFromCorbiz($ws,$countryKey,$lang){
        $response    = ['status' => false, 'data' => [], 'messages' => [], 'numDocs' => 0];
        $restWrapper = new RestWrapper("{$ws}getDocumentsId?CountryKey=USA&Lang=ING");

        $responseWS  = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['IdDocuments']['dsIdDocuments']['ttIdDocuments'])) {
            $response['status'] = true;
            foreach ($responseWS['responseWS']['response']['IdDocuments']['dsIdDocuments']['ttIdDocuments'] as $document) {
                $response['data'][] = ['id' => trim($document['IdDocuments']), 'name' => trim($document['descriptions'])];
            }

            $countryDocuments = Config::get('shopping.documents_corbiz');


            foreach ($countryDocuments as $countryDocument => $numDocs)
            {

                if ($countryKey == $countryDocument)
                {
                    $response['numDocs'] = $numDocs['cant'];
                    $response['active_expiration'] = $numDocs['active_expiration'];
                }
            }
        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [

                    trim($responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser']),

                ];
            } else {
                if (isset($responseWS['message'])) {
                    $response['messages'] = [$responseWS['message']];
                } else {
                    $response['messages'] = [trans('shopping::zip.errors.404')];
                }
            }
        }

        return $response;
    }


    public function getShippingCompaniesFromCorbiz($ws,$countryKey,$lang,$stateKey,$cityKey){


        $response    = ['status' => false, 'data' => [], 'messages' => []];
        $restWrapper = new RestWrapper("{$ws}getShippingCompanies?CountryKey={$countryKey}&Lang={$lang}&StateKey={$stateKey}&CityKey={$cityKey}");
        $responseWS  = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['ShippingCompanies']['dsShippingCompanies']['ttShippingCompanies'])) {
            $response['status'] = true;
            foreach ($responseWS['responseWS']['response']['ShippingCompanies']['dsShippingCompanies']['ttShippingCompanies'] as $scompany) {
                $response['data'][] = ['id' => trim($scompany['comp_env']), 'name' => trim($scompany['descripcion'])];
            }
        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [

                    trim($responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser']),

                ];
            } else {
                if (isset($responseWS['message'])) {
                    $response['messages'] = [$responseWS['message']];
                } else {
                    $response['messages'] = [trans('shopping::zip.errors.404')];
                }
            }
        }

        return $response;
    }

    public function getCitiesFromCorbiz($ws,$countryKey,$lang,$state){
            $response    = ['status' => false, 'data' => [], 'messages' => []];
            $restWrapper = new RestWrapper("{$ws}getCity?CountryKey={$countryKey}&Lang={$lang}&StateKey={$state}");
            $responseWS  = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);

            if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['City']['dsCity']['ttCity'])) {
                $response['status'] = true;
                foreach ($responseWS['responseWS']['response']['City']['dsCity']['ttCity'] as $state) {
                    $response['data'][] = ['id' => trim($state['idCity']), 'name' => trim($state['cityDescr'])];
                }

            } else {
                if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                    $response['messages'] = [
                        $responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser'],
                    ];
                } else {
                    if (isset($responseWS['message'])) {
                        $response['messages'] = [$responseWS['message']];
                    } else {
                        $response['messages'] = [trans('cms::cedis.errors.404')];
                    }
                }
            }

            return $response;
        }

    public function getZipCodesFromCorbiz($ws,$countryKey,$lang,$code){

        $response    = ['status' => false, 'data' => [], 'messages' => []];
        $restWrapper = new RestWrapper("{$ws}getZipCode?CountryKey={$countryKey}&Lang={$lang}&ZipCode={$code}");

        $responseWS  = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['ZipCode']['dsZIPCode']['ttZipCode'])) {
            $response['status'] = true;
            foreach ($responseWS['responseWS']['response']['ZipCode']['dsZIPCode']['ttZipCode'] as $zip) {
                $label = trim($zip['zipCode']).",".trim($zip[config('shopping.zip.'.$countryKey.'.check')]).", ". trim($zip['idCity']).", ". trim($zip['idState']);
                $response['suggestions'][] = array(
                    'value' => $label,
                    'data' => array('zipcode' => trim($zip['zipCode']),
                              'idState' => trim($zip['idState']),
                              'stateDescr' => trim($zip['stateDescr']),
                              'idCity' => trim($zip['idCity']),
                              'cityDescr' => trim($zip['cityDescr']),
                              'country' => trim($zip['country']),
                              'county' => trim($zip['county']),
                              'suburb' => trim($zip['suburb']))
                );
            }

        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [
                    $responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser'],
                ];
            } else {
                if (isset($responseWS['message'])) {
                    $response['messages'] = [$responseWS['message']];
                } else {
                    $response['messages'] = [trans('shopping::zip.errors.404')];
                }
            }
        }

        return $response;
    }

    /* Métodos para las órdenes */
    /**
     * getNextOrderNumber
     * Regresa el número siguiente de una órden por país, si no se encuentra el país, se regresa la órden con el número
     * 1. Ej XX00000001, donde XX es el ID del país
     *
     * @param int $countryId    ID del país
     * @param int $len          Longitud del número de orden contando el ID del país
     * @return bool|string      False si no se define el ID del país o el número de órden en caso contrario
     */
    public function getNextOrderNumber($countryId = null, $len = 10) {

        if (is_null($countryId)) {
            return false;
        }

        $preNumber = '';
        $lastOrder = Order::where('country_id', $countryId)
            ->orderBy('order_number', 'DESC')
            ->first();




        if (is_null($lastOrder)) {
            $preNumber = str_pad('1', ($len - strlen($countryId.'')), '0', STR_PAD_LEFT);

        } else {
            $preNumber = substr($lastOrder->order_number.'', strlen($countryId.''));
            $preNumber = ((int)$preNumber) + 1;
            $preNumber = str_pad($preNumber.'', ($len - strlen($countryId.'')), '0', STR_PAD_LEFT);


        }



        return "{$countryId}{$preNumber}";
    }

    /**
     * saveModelData
     * Helper para guardar los datos de cualquier modelo sin necesidad de instanciar la propia clase
     *
     * Ej. 1
     * $user = new User();
     * $user->name = 'User name';
     * $user->email = 'user@email.com'
     * $user->pass = 'User password';
     * $user->save();
     *
     * Ej. 2
     * $user = saveModelData(['name' => 'User name', 'email' => 'user@email.com', 'pass' => 'User password'], User::class);
     *
     * Los ejemplos 1 y 2 son equivalentes. Usar saveModelData permite guardar información en n cantidad de columnas (según
     * lo permita la definición de la tabla) para m cantidad de modelos.
     *
     * @param array $data       Arreglo del tipo clave => valor, donde 'clave' es el nombre del atributo o columna del
     *                          modelo o tabla y 'valor' la información correspondiente al campo
     * @param null $modelClass  Nombre del modelo, Ej. User::class
     * @return bool             Regresa false en caso que no se guarde el objeto o regresa la instancia creada del modelo
     */
    public function saveModelData(array $data = [], $modelClass = null) {

        if (!empty($data) && !is_null($modelClass)) {
            $modelObject = new $modelClass;

            if (is_subclass_of($modelObject, 'Eloquent') || is_subclass_of($modelObject, 'Model')) {
                foreach ($data as $column => $value) {

                    $modelObject->$column = $value;
                }
                if ($modelObject->save()) {

                    return $modelObject;
                }
            }
        }

        return false;
    }

    public function getOrderStatusId($key, $countryId) {
        $orderStatus = OrderEstatus::whereHas('orderEstatusCountry', function ($q) use ($countryId) {
            $q->where('country_id', $countryId);
        })->where('key_estatus', $key)->first();


        return $orderStatus != null ? $orderStatus->id : false;
    }

    public function getTransactionFromCorbiz(string $ws, string $countryKey, string $langKey, $salesWeb = [], $salesWebItems = []) {
        $response    = ['status' => false, 'data' => [], 'messages' => []];
        $restWrapper = new RestWrapper("{$ws}addFormSalesTransaction");

        $params = ['request' => [
            'CountryKey' => $countryKey,
            'Lang'       => $langKey,
            'SalesWeb'   => [
                'ttSalesWeb' => [$salesWeb],
            ],
        ]];

        if (!empty($salesWebItems)) {
            $params['request']['SalesWebItems']['ttSalesWebItems'] = $salesWebItems;
        }

        $responseWS = $restWrapper->call("POST", $params,'json', ['http_errors' => false]);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['Transaction'])) {
            $response['status'] = true;
            $response['data']['transaction'] = $responseWS['responseWS']['response']['Transaction'];
        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [
                    trim($responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser']),
                ];
            } else {
                if (isset($responseWS['message'])) {
                    $response['messages'] = [$responseWS['message']];
                } else {
                    $response['messages'] = [trans('shopping::zip.errors.404')];
                }
            }
        }

        return $response;
    }

    public function getOrderFromCorbiz(string $ws, string $countryKey, string $langKey, $salesWeb = [], $salesWebItems = []) {
        $response    = ['status' => false, 'data' => [], 'messages' => []];

        $restWrapper = new RestWrapper($ws."addSalesWeb");
        $params = ['request' => [
            'CountryKey' => $countryKey,
            'Lang' => $langKey,
            'SalesWeb' => [
                'ttSalesWeb' => [
                    $salesWeb
                ],
            ],
            'SalesWebItems' => [
                'ttSalesWebItems' => $salesWebItems
            ]
        ]];


        $responseWS = $restWrapper->call("POST", $params,'json', ['http_errors' => false]);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['Success']) && $responseWS['responseWS']['response']['Success'] == 'true') {
            $response['status']                = true;
            $response['data']['salesweb']      = $responseWS['responseWS']['response']['SalesWeb']['dsSalesWeb']['ttSalesWeb'][0];
            $response['data']['saleswebitems'] = $responseWS['responseWS']['response']['SalesWebItems']['dsSalesWebItems']['ttSalesWebItems'];
            $response['data']['order']         = $responseWS['responseWS']['response']['Orden'];
        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [
                    trim($responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser']),
                ];

                $response['err_order'] = [
                    'error_user'   => $responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser'],
                    'error_corbiz' => $responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messTech'],
                ];
            } else {
                if (isset($responseWS['message'])) {
                    $errMessage           = $responseWS['message'];
                    $response['messages'] = [$errMessage];

                } else {
                    $errMessage           = trans('shopping::zip.errors.404');
                    $response['messages'] = [$errMessage];
                }

                $response['err_order'] = [
                    'error_user'   => $errMessage,
                    'error_corbiz' => $errMessage,
                ];
            }
        }

        return $response;
    }

    public function addFormEntrepreneur(string $ws,string $countryKey,string $langkey,$formEntepreneur = [],$docsEntepreneur = []){
        $response    = ['status' => false, 'data' => [], 'messages' => []];
        $restWrapper = new RestWrapper($ws."addFormEntrepreneur");
        $params = ['request' => [
            'CountryKey' => $countryKey,
            'Lang' => $langkey,
            'AddFormEntrepreneur' => [
                'ttAddFormEntrepreneur' => [
                        $formEntepreneur
                ],
            ],
            'AddFormDoctos' => [
                'ttAddFormDoctos' => $docsEntepreneur
            ]
        ]];

        $resultValidFormEntrepreneur = $restWrapper->call("POST",$params,'json', ['http_errors' => false]);

        if($resultValidFormEntrepreneur['success'] && $resultValidFormEntrepreneur['responseWS']['response']['Success'] == 'true')
        {
            //validacion correcta
            $response['status'] = true;

        }else if(!$resultValidFormEntrepreneur['success']  && $resultValidFormEntrepreneur['responseWS']['response']['Success'] == 'false' && isset($resultValidFormEntrepreneur['responseWS']['response']['Error']['dsError']['ttError'])){
            //errores del servicio falla al validar formulario
            foreach ($resultValidFormEntrepreneur['responseWS']['response']['Error']['dsError']['ttError'] as $i => $err){

                $response['messages'] = [
                    $err['messUser']
                ];
            }

        }else{
            //errores no controlados excepciones
            if (isset($resultValidFormEntrepreneur['message'])) {
                $response['messages'] = [$resultValidFormEntrepreneur['message']];
            } else {
                $response['messages'] = [trans('shopping::formvalidate.errors.404')];
            }

        }

        return $response;
    }

    /**
     * addEntrepreneur
     * Invoca el webservice addEntepreneur para grabar los datos del Eo en Corbiz
     *
     * @param string $ws       conexión de webservice de corbiz
     * @param string $countryKey país en el que se va a registrar el Eo
     * @param string $langkey    idioma del país seleccionado
     * @param string $transaction transaccion generada por corbiz
     * @param null $modelClass  Nombre del modelo, Ej. User::class
     * @return bool             Regresa false en caso que no se guarde el objeto o regresa la instancia creada del modelo
     */
    public function addEntrepreneur(string $ws,string $countryKey,string $langkey,string $transaction){

        $response    = ['status' => false, 'data' => [], 'messages' => []];
        $restWrapper = new RestWrapper($ws."addEntrepreneur");
        $params = ['request' => [
            'CountryKey' => $countryKey,
            'Lang' => $langkey,
            'AddEntrepreneur' => [
                'ttAddEntrepreneur' => [
                    [
                        'countrySale' => $countryKey,
                        'idTransaction' => $transaction //transacción devuelta por addSalesTransaction
                    ]
                ],
            ]
        ]];

        $resultAddEntrepreneur = $restWrapper->call("POST",$params,'json', ['http_errors' => false]);

        if($resultAddEntrepreneur['success'] && $resultAddEntrepreneur['responseWS']['response']['Success'] == 'true')
        {
            //crea el eO
            $response['status'] = true;
            $response['data'] = ['eonumber' => $resultAddEntrepreneur['responseWS']['response']['EntrepreneurId'],'password' => $resultAddEntrepreneur['responseWS']['response']['Password'],'question' => $resultAddEntrepreneur['responseWS']['response']['Question']];

        }else if(!$resultAddEntrepreneur['success']  && $resultAddEntrepreneur['responseWS']['response']['Success'] == 'false' && isset($resultAddEntrepreneur['responseWS']['response']['Error']['dsError']['ttError'])){
            //errores del servicio falla al validar formulario
            foreach ($resultAddEntrepreneur['responseWS']['response']['Error']['dsError']['ttError'] as $i => $err){
                $response['messages'] = [
                    $err['messUser']
                ];
            }

        }else{
            //errores no controlados excepciones
            if (isset($resultValidFormEntrepreneur['message'])) {
                $response['messages'] = [$resultValidFormEntrepreneur['message']];
            } else {
                $response['messages'] = [trans('shopping::formvalidate.errors.404')];
            }

        }

        return $response;
    }


    public function getShippingCompanies($stateKey="",$cityKey=""){
        //getShippingCompanies
        $restWrapper = new RestWrapper(session()->get('portal.main.webservice')."getShippingCompanies?CountryKey=".session()->get('portal.main.country_corbiz')."&Lang=".session()->get('portal.main.language_corbiz')."&StateKey=$stateKey&CityKey=$cityKey");
        $responseWS = $restWrapper->call("GET",[],'json', ['http_errors' => false]);
        //dd($resultShippingCompanies);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['ShippingCompanies']['dsShippingCompanies']['ttShippingCompanies'])) {
            $response['status'] = true;
            foreach ($responseWS['responseWS']['response']['ShippingCompanies']['dsShippingCompanies']['ttShippingCompanies'] as $shippingCompany) {
                $response['data'][] = array(
                    'comp_env' => trim($shippingCompany['comp_env']),
                    'descripcion' => trim($shippingCompany['descripcion'])
                );
            }
        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [
                    $responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser'],
                ];
            } else {
                if (isset($responseWS['message'])) {
                    $response['messages'] = [$responseWS['message']];
                } else {
                    $response['messages'] = [trans('shopping::zip.errors.404')];
                }
            }
        }
        return $response;
    }

    /* Obtener Almacen con Zip Code */
    public function getAvailableWH($ws_country = '', $country = '', $lang = '', $stateKey = '', $cityKey = '', $zip = '')
    {
        $restWrapper    = new RestWrapper($ws_country . "getAvailableWH?CountryKey=$country&Lang=$lang&StateKey=$stateKey&CityKey=$cityKey&ZipCode=$zip");
        $result         = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);

        if ($result['success'] == true && isset($result['responseWS']['response']['Warehouse']['dsWarehouse']['ttWarehouse'][0]))
        {
            $response = [
                'success'   => true,
                'message'   => $result['responseWS']['response']['Warehouse']['dsWarehouse']['ttWarehouse'][0],
            ];
        }
        else if ($result['success'] == false && isset($result['responseWS']['response']['Error']['dsError']['ttError']))
        {
            $response = [
                'success'   => false,
                'message'   => $result['responseWS']['response']['Error']['dsError']['ttError'],
            ];
        }
        else
        {
            $response = [
                'success'   => false,
                'message'   => [
                    'error_ws'  => trans('shopping::register_customer.error_rest'),
                ],
            ];
        }

        return $response;
    }








    /*Llamado a base de datos obtener catalogos*/

    /**
     * getCountries
     * Realiza la petición del método getCountries a DB y se formatea su respuesta
     *
     * @return array        Respuesta de la petición
     */
    public function getCountries(){

        $success = false;
        $message = '';
        $data = array();

        try{
            $countries = Country::where(['active' => 1,'inscription_active' => 1])->get();

            if($countries != null){
                $success = true;
                $data = $countries;

            }
         }catch(Exception $e){

            $message = $e->getMessage();
        }
        return ['success' => $success,'message' => $message,'data' => $data];

    }

    /**
     * getPool
     * Realiza la petición del método getPool a DB para obtener el pool de empresarios del pais
     * @param  $country     Id del pais
     * @return array        Respuesta de la petición
     */
    public function getPool($country = null){
        $success = false;
        $message = "";
        $data = array();
        if(!empty($country)){

            try{

                $totalPool = DistributorsPool::where('country_id',$country)->count();

                if($totalPool > 0)
                {
                    $totalPoolUsed = DistributorsPool::where(['used' => 1,'country_id' => $country])->count();


                    if($totalPoolUsed == $totalPool)
                    {
                        DistributorsPool::where(['used' => 1,'country_id' => $country])->update(['used' => '0']);
                    }

                    $poolEo = DistributorsPool::where(['used' => 0,'country_id' => $country])->get()->random(1)->first();


                        DistributorsPool::where(['distributor_code' => $poolEo->distributor_code,'country_id' => $poolEo->country_id])->update(['used' => 1]);

                        $message = 'OK '.$poolEo->distributor_code;
                        $success = true;




                    $data = array('distributor_name' => $poolEo->distributor_name, 'distributor_email' => $poolEo->distributor_email, 'distributor_code' => $poolEo->distributor_code );
                }
                else{
                    $message = trans('shopping::register.account.country.emptypool');
                }



            }catch(\Exception $ex)
            {

                $message = $ex->getMessage();

            }

        }
        else{
            trans('shopping::register.account.country.emptycountry');
        }

        return ['success' => $success, 'message' => $message, 'data' => $data];

    }

    /**
     * getRegistrationReferences
     * Realiza la petición del método getRegistrationReferences a DB para obtener las referencias dispobibles por país e idioma
     * @param  $country     Id del pais
     * @param  $lang        locale del idioma
     * @return array        Respuesta de la petición
     */
    public function getRegistrationReferences($country = null){
        $success = false;
        $message = trans('shopping::register.account.country.emptydata');
        $data = array();

        if(!empty($country)){
            try{

                $data = RegistrationReferences::select('shop_registration_references.id')
                    ->join('shop_registration_references_countries', 'shop_registration_references.id', 'shop_registration_references_countries.registration_references_id')
                    ->where('shop_registration_references_countries.country_id', $country)
                    ->where('shop_registration_references.active', 1)
                    ->where('shop_registration_references.delete',0)
                    ->get();


                if(!$data->isEmpty()){
                    $message = '';
                    $success = true;
                }


            }catch(\Exception $ex)
            {

                $message = $ex->getMessage();


            }

        }


        return ['success' => $success, 'message' => $message, 'data' => $data];
    }

    /**
     * getSecretQuestions
     * Realiza la petición del método getSecretQuestions a DB para obtener las preguntas secretas por país e idioma
     * @param  $country     Id del pais
     * @param  $lang        locale del idioma
     * @return array        Respuesta de la petición
     */
    public function getSecretQuestions($country = null){
        $success = false;
        $message = trans('shopping::register.account.secret_question.emptydata');
        $data = array();


        if(!empty($country)){

            try{


                $data = SecurityQuestions::select('shop_security_questions.id')
                    ->join('shop_security_questions_countries', 'shop_security_questions_countries.security_questions_id', '=', 'shop_security_questions.id')
                    ->where('shop_security_questions.active', '=', 1)
                    ->where('shop_security_questions.delete', '=', 0)
                    ->where('shop_security_questions_countries.country_id', $country)->get();




                if(!$data->isEmpty()){
                    $message = '';
                    $success = true;
                }






            }catch(\Exception $ex)
            {

                $message = $ex->getMessage();


            }

        }


        return ['success' => $success, 'message' => $message, 'data' => $data];
    }

    /**
     * getRegistrationParameters
     * Realiza la petición del método getRegistrationParameters a DB para obtener los parametros de configuración de inscripcion
     * @param  $country     Id del pais
     * @return array        Respuesta de la petición
     */
    public function getRegistrationParameters($country = null){
        $success = false;
        $message = trans('shopping::register.account.parameters.emptydata');
        $data = array();

        if(!empty($country)){

            try{

                $info  = RegistrationParameters::where(['country_id'=> $country,'active' => 1,'delete' => 0])->first();

                if(!empty($info)){

                    $yearIni = Carbon::now()->year - $info->min_age;
                    $yearFin = isset($info->max_age) ? Carbon::now()->year - $info->max_age : $yearIni;
                    $data  = ['min_age' => $info->min_age,'max_age' => $info->max_age,'has_documents' => $info->has_documents,'fechain' => $yearIni,'fecha_fin' => $yearFin];
                    $message = '';
                    $success = true;

                }


            }catch(\Exception $ex)
            {

                $message = $ex->getMessage();


            }

        }


        return ['success' => $success, 'message' => $message, 'data' => $data];
    }

    /**
     * getLegalDocuments
     * Realiza la petición del método getLegalDocuments a DB para obtener los documentos legales correspondientes al país
     * @param  $country     Id del pais
     * @lang   $lang        locale del país
     * @return array        Respuesta de la petición
     */
    public function getLegalDocuments($country = null){
        $success = false;
        $message = trans('shopping::register.account.country.emptydata');
        $data = array();
        $config = array();

        if(!empty($country)){

            try{

                $data = Legal::where('shop_legals.country_id', $country)
                    ->where('shop_legals.active', 1)
                    ->where('shop_legals.delete',0)
                    ->first();


                if($data != null){
                    $message = '';
                    $success = true;

                    $config = ['active_transfer' => config('shopping.documents.'.Session::get('portal.register.country_corbiz').'.transfer'),'active_information' => config('shopping.documents.'.Session::get('portal.register.country_corbiz').'.receive')];


                }






            }catch(\Exception $ex)
            {

                $message = $ex->getMessage();


            }

        }


        return ['success' => $success, 'message' => $message, 'data' => $data,'config' => $config];
    }

    /**
     * getBanks
     * Realiza la petición del método getBanks a DB para obtener los métodos de pagos correspondientes al país
     * @param  $country     Id del pais
     * @lang   $lang        locale del país
     * @return array        Respuesta de la petición
     */
    public function getBanks($country = null){
        $success = false;
        $message = trans('shopping::register.account.country.emptydata');
        $data = array();

        if(!empty($country)){

            try{

                $data = Bank::select('shop_banks.*')
                    ->join('shop_bank_countries', 'shop_banks.id', 'shop_bank_countries.banks_id')
                    ->where('shop_bank_countries.country_id', $country)
                    ->where('shop_banks.active', 1)
                    ->where('shop_banks.delete',0)
                    ->get();



                if(!$data->isEmpty()){
                    $message = '';
                    $success = true;
                }






            }catch(\Exception $ex)
            {

                $message = $ex->getMessage();


            }

        }


        return ['success' => $success, 'message' => $message, 'data' => $data];
    }

    public function getkitsInscription($country = null){
        $success = false;
        $message = trans('shopping::register.account.country.emptydata');
        $data = array();

        if(!empty($country)){

            try{

                $data = CountryProduct::select('shop_country_products.*','shop_products.sku')
                    ->join('shop_products', 'shop_products.id', 'shop_country_products.product_id')
                    ->where('shop_country_products.country_id', $country)
                    ->where('shop_country_products.active', 1)
                    ->where('shop_products.is_kit',1)
                    ->get();


                if(!$data->isEmpty()){
                    $message = '';
                    $success = true;
                }






            }catch(\Exception $ex)
            {

                $message = $ex->getMessage();


            }

        }


        return ['success' => $success, 'message' => $message, 'data' => $data];

    }

    /* Envio de Mail */
    public function getSendMail($data = '')
    {
        return Mail::send($data['view_mail'], ['data' => $data], function($m) use ($data) {
            $m->from($data['from_email'], $data['title']);
            $m->to($data['to_email'], $data['name'])->subject($data['subject']);

            if (isset($data['attachPdf'])) {
                $m->attach($data['attachPdf']);
            }
        });
    }

    public function getWarehouseId($country,$warehousename){
        $warehouseId = WarehouseCountry::getWarehouseId($country,$warehousename);

        return $warehouseId;
    }



}
?>