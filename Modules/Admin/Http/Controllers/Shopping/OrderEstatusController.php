<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers\Shopping;



use Modules\Admin\Entities\Country;
use Modules\Shopping\Entities\OrderEstatus;
use Modules\Shopping\Entities\OrderEstatusCountry;
use Modules\Shopping\Entities\OrderEstatusTranslation;
use Modules\Shopping\Entities\OrderEstatusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Language;
use Image;
use View;
use Validator;
use Auth;
use Modules\CMS\Libraries\Builder\FormMessage;
use Modules\Admin\Http\Controllers\AdminController as Controller;


/**
 * Description of OrderEstatusController
 *
 * @author Alan
 */
class OrderEstatusController extends Controller {

    public function indexOrderEstatus($message = "", $validacion = "") {



        //$countries = Country::selectArrayActive();
        $countriesUser = Auth::user()->countries;
        $countries = [];
        foreach ($countriesUser as $uc){

            $countries[$uc->id] = $uc->name;


        }
        $languagesList = Language::where('active', '=', 1)->get();


        $this->layoutData['content'] = View::make('admin::shopping.orderestatus.forms.add', array('countries' => $countries,
                    'languages' => $languagesList,
                    'msg' => $message,
                    'can_add' => Auth::action('orderestatus.add'),
                    'can_delete' => Auth::action('orderestatus.delete'),
                    'can_activate' => Auth::action('orderestatus.activate'),
                    'can_edit' => Auth::action('orderestatus.editOe'),
                    'validacion' => $validacion,
                    'add' => 1));
    }

    public function showListOrderEstatus() {
        $orderestatus = OrderEstatus::all()->where('delete','=',0);



        $this->layoutData['content'] = View::make('admin::shopping.orderestatus.list', array('orderestatus' => $orderestatus,
                    'can_add' => Auth::action('orderestatus.add'),
                    'can_delete' => Auth::action('orderestatus.active'),
                    'can_edit' => Auth::action('orderestatus.edit'),
        ));
    }

//    public function getListBrands() {
//        return json_encode($this->getBrandTraslations());
//    }

    public function saveOrderStatus(Request $request) {
       // dd($request->all());
        if ($request->isMethod('post')) {
                //validación campos globales requeridos
                $v = Validator::make($request->all(), array(
                            'key' => 'required'
                            )
                );


                $attrNamesTrans = array(
                    'key' => trans('admin::shopping.orderestatus.add.keyempty'),

                );
                $v->setAttributeNames($attrNamesTrans);
//            return json_encode($this->validateTraslations($request));

            if ($this->validateTraslations($request)) {
                $validateLanguages = $this->validateTranslationsLanguages($request);

                if($validateLanguages['success']) {
                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();
                            //Se almacena en la tabla principal shop_orderestatus
                            $data = [
                                'active' => '1',
                                'key_estatus' => $request->key,
                                'paises' => $request->country_id];
                            $orderestatus = OrderEstatus::create($data);
                            //Bloque para almacenar en shop_orderestatus_countries
                            foreach ($request->country_id as $country) {
                                $saveOrderEstatus[] = ['order_estatus_id' => $orderestatus->id, 'country_id' => $country, 'active' => 1];
                                $availableLanguages[] = $this->validateLanguages($country);
                            }

                            $orderestatus->orderEstatusCountry()->createMany($saveOrderEstatus);
                            //Final bloque almacenar shop_orderestatus_countries
                            // bloque para almacenar traducciones
                            $valores = $this->setOrderEstatusLanguages($request, $orderestatus->id, $availableLanguages);

                            $orderestatus->orderEstatusTraslations()->createMany($valores);

                            ///$this->setOrderEstatusLanguages($request, $orderestatus->id, $availableLanguages);
                            //final bloque almacenar traducciones
                            DB::commit();

                            $message = \Session::flash('info', array('message' => trans('admin::shopping.orderestatus.add.success'), 'alertclass' => 'alert-success'));


                            return redirect()->route('admin.orderestatus.list', $message);
                        } catch (Exception $ex) {
                            DB::rollback();
                            $message = \Session::flash('info', array('message' => trans('admin::shopping.orderestatus.add.failed'), 'alertclass' => 'alert-danger'));

                            return redirect()->route('admin.orderestatus.list', $message);
                        }
                    } else {
                        $mensage = $v->messages();
                        return redirect()->back()
                            ->withInput($request->all())
                            ->withErrors([$mensage]);
                    }
                }
                else{
                    //dd($validateLanguages['message']);
                    $mensage = trans('admin::menu.traslates_name_countries');
                    foreach ($validateLanguages['message'] as $vl){
                        $mensage .= $vl.",";
                    }

                    return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors([$mensage]);
                }
            } else {
                $mensage = trans('admin::menu.traslates_name');
                return redirect()->back()
                    ->withInput($request->all())
                    ->withErrors([$mensage]);
            }
        }

    }

    private function validateTraslations($request) {
        $totales = count($request->orderestatus_name);
        $cantidad = 0;
        foreach ($request->orderestatus_name as $name) {
            if ($name == null) {
                $cantidad = $cantidad + 1;
            }
        }
        if ($cantidad < $totales) {
            return true;
        } else {
            return false;
        }
    }

    private function validateTranslationsLanguages($request){
        //si minimo hay una traduccion insertada, se valida que esten las traducciones de los paises seleccionados
        $cantidadllenos = 0;
        $contadorIdiomas = 0;

        foreach ($request->country_id as $country) {

            $availableLanguages[$country]  = $this->validateLanguagesFields($country);

        }
        $idiomasSeparados = [];
        foreach ($availableLanguages as $key => $al){
            foreach ($al as $aa){
                //var_dump(in_array($aa,$idiomasSeparados));
                if(!in_array($aa,$idiomasSeparados)){
                    $idiomasSeparados[] = $aa;
                }
            }
        }

        foreach ($request->orderestatus_name as $key => $val){
            if(!empty($val)){
                if(in_array($key,$idiomasSeparados)){
                    $contadorIdiomas = $contadorIdiomas + 1;
                }
            }
        }

        $cantidadRequeridaTraducciones = count($idiomasSeparados);

        //dd($cantidadllenos,$cantidadRequeridaTraducciones);
        if($contadorIdiomas < $cantidadRequeridaTraducciones){
            //return false;
            return ['success' => false,'message'=> $idiomasSeparados];
        }

        return ['success' => true,'message'=> ''];
    }


    public function updateOrderEstatus(Request $request) {

        if ($request->isMethod('post')) {

                $v = Validator::make($request->all(), array(
                            'key' => 'required',
                            )
                );
                $attrNamesTrans = array(
                    'key' => trans('admin::shopping.orderesttaus.update.emptykey'),

                );
                $v->setAttributeNames($attrNamesTrans);


            if ($this->validateTraslations($request)) {
                $validateLanguages = $this->validateTranslationsLanguages($request);

                if($validateLanguages['success']) {
                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();

                            $orderestatus = OrderEstatus::find($request->id_order_estatus);
                            $orderestatus->name = $request->nombre;
                            $orderestatus->active = 1;


                            foreach ($request->country_id as $country) {
                                $saveOrderEstatus[] = ['order_estatus_id' => $orderestatus->id, 'country_id' => $country, 'active' => 1];
                                $availableLanguages[] = $this->validateLanguages($country);
                            }

                            $orderestatus_languages = $this->setOrderEstatusLanguages($request, $orderestatus->id, $availableLanguages);

                            $orderestatus->orderEstatusCountry()->delete();
                            $orderestatus->orderEstatusCountry()->createMany($saveOrderEstatus);
                            $orderestatus->orderEstatusTraslations()->delete();
                            $orderestatus->orderEstatusTraslations()->createMany($orderestatus_languages);
                            $orderestatus->save();
                            DB::commit();
                            $message = \Session::flash('info', array('message' => trans('admin::shopping.orderestatus.update.success'), 'alertclass' => 'alert-success'));

                            return redirect()->route('admin.orderestatus.list', $message);
                        } catch (Exception $e) {
                            DB::rollback();
                            $mensage = \Session::flash('info', array('message' => trans('admin::shopping.orderestatus.add.failed'), 'alertclass' => 'alert-danger'));
                            return redirect()->back()
                                ->withInput($request->all())
                                ->withErrors([$mensage]);
                        }
                    } else {
                        $mensage = $v->messages();
                        return redirect()->back()
                            ->withInput($request->all())
                            ->withErrors([$mensage]);
                    }
                }
                else{
                    //dd($validateLanguages['message']);
                    $mensage = trans('admin::menu.traslates_name_countries');
                    foreach ($validateLanguages['message'] as $vl){
                        $mensage .= $vl.",";
                    }

                    return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors([$mensage]);
                }
            } else {
                $mensage = trans('admin::menu.traslates_name');
                return redirect()->back()
                    ->withInput($request->all())
                    ->withErrors([$mensage]);
            }
        }
    }

    public function validateLanguagesFields($country_id){

        $country= Country::find($country_id);
        $languagesAvailable = [];

        foreach ($country->languagesRelated as $ca){

            array_push($languagesAvailable,$ca->locale_key);
        }

        return $languagesAvailable;

    }


    private function setOrderEstatusLanguages($request, $orderestatus_id, $availableLanguages) {
        //dd($request->all(),$orderestatus_id,$availableLanguages);
        $orderestatus_languages = array();
        if (count($request->orderestatus_name) > 0 && count($request->orderestatus_locale) > 0) {
            $index = 0;
            foreach ($request->orderestatus_name as $key => $name) {
                    $exists = $this->existsKey($request->orderestatus_locale[$index],$availableLanguages);

                    if($exists){


                        $orderEstatusObj = new OrderEstatusModel();
                        $orderEstatusObj->name = ($name == null) ? '' : $name;
                        $orderEstatusObj->order_estatus_id = $orderestatus_id;
                        $orderEstatusObj->description = ($request->description[$key] == null) ? '' : $request->description[$key];
                        $orderEstatusObj->locale = $request->orderestatus_locale[$index];
                        array_push($orderestatus_languages, get_object_vars($orderEstatusObj));

                    }


                $index = $index + 1;
            }
        }

        return $orderestatus_languages;
    }

    public function activeOrderStatus(Request $request) {

        $orderestatus = OrderEstatus::find($request->order_estatus_id);

        if ($orderestatus != null) {
            if ($orderestatus->active == true) {
                $orderestatus->active = 0;
                $orderestatus->save();

                $oeCountries = $orderestatus->orderEstatusCountry;

                foreach ($oeCountries as $oec){
                    $oeCountry = OrderEstatusCountry::find($oec->id);
                    $oeCountry->active = 0;
                    $oeCountry->save();
                }



                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            } else {
                $orderestatus->active = 1;
                $orderestatus->save();

                $oeCountries = $orderestatus->orderEstatusCountry;

                foreach ($oeCountries as $oec){
                    $oeCountry = OrderEstatusCountry::find($oec->id);
                    $oeCountry->active = 1;
                    $oeCountry->save();
                }


                $response = array(
                    'status' => 1,
                    'message' => trans('admin::menu.active')
                );
            }
            return $response;
        } else {
            return "";
        }
    }

    public function existsKey($lankey,$datos){
        //dd($lankey,$datos);

            foreach ($datos as $d) {

                foreach ($d as  $dd){
                    if ($dd === $lankey) {
                        return true;
                    }
                }
            }
       return false;


    }

    public function validateLanguages($country_id){

        $country= Country::find($country_id);
        $languagesAvailable = [];
        foreach ($country->languagesRelated as $ca){

            array_push($languagesAvailable,$ca->locale_key);

        }

        return $languagesAvailable;

    }

    public function deleteOrderStatus(Request $request) {

        $orderestatus = OrderEstatus::find($request->order_estatus_id);

        if ($orderestatus != null) {

                $orderestatus->delete = 1;
                $orderestatus->save();
                $response = array(
                    'status' => true,
                    'message' => trans('admin::menu.deleted'),
                );

            return $response;
        } else {
            return "";
        }
    }

    public function CountriesReference(Request $request) {

        $orderestatus = OrderEstatus::find($request->oe_id);
        $countries = $orderestatus->orderEstatusCountry;


        if ($orderestatus != null) {

            $countriesEstatus = [];

            foreach ($countries as $ct){
                $countriesEstatus[$ct['country_id']] = ['estatus'=> $ct['active'],'name' => $ct->country->name];
            }

            return ['success' => true,'message'=> $countriesEstatus];
        } else {
            return ['success' => false,'message'=> trans('admin::shopping.banks.index.emptycountries')];
        }
    }


    public function updatesCountries(Request $request) {

        try {

            DB::beginTransaction();

            $countries = $request->countries_name;


            $references = OrderEstatusCountry::where('order_estatus_id', $request->reference_identifier)->get();
            foreach ($references as $rf) {
                //dd(array_key_exists($bk->country_id,$countries),$countries,$bk);
                if (array_key_exists($rf->country_id, $countries)) {
                    $update = OrderEstatusCountry::find($rf->id);
                    $update->active = 1;
                    $update->save();
                } else {
                    $update = OrderEstatusCountry::find($rf->id);
                    $update->active = 0;
                    $update->save();
                }

            }

            DB::commit();
            $message = \Session::flash('info', array('message' => trans('admin::shopping.banks.index.countriesupdated'), 'alertclass' => 'alert-success'));
            return redirect()->route('admin.orderestatus.list', $message);
        }catch(Exception $e){
            DB::rollback();
            $message = \Session::flash('info',array('message' => trans('admin::shopping.banks.index.failedcountries'),'alertclass' => 'alert-danger'));

            return redirect()->route('admin.orderestatus.list',$message);
        }






    }




    public function getOrderEstatus($id_orderestatus = 0, $message = "", $validacion = "") {
        $orderestatus = OrderEstatus::find($id_orderestatus);

        if ($orderestatus != null) {
            //$countries = Country::selectArrayActive();
            $countriesUser = Auth::user()->countries;
            $countries = [];
            foreach ($countriesUser as $uc){

                $countries[$uc->id] = $uc->name;


            }
            $countriesSelected = OrderEstatus::find($id_orderestatus)->orderEstatusCountry;
            $languagesList = Language::where('active', '=', 1)->get();
            $languagesList2 = $this->getTraslations($orderestatus->orderEstatusTraslations, $languagesList);

            $this->layoutData['content'] = View::make('admin::shopping.orderestatus.forms.update', array(
                        'countriesSelected' => array_pluck(
                                $countriesSelected, 'country_id'),
                        'countries' => $countries,
                        'languages' => $languagesList2,
                        'orderestatus' => $orderestatus,
                        'msg' => $message,
                        'validacion' => $validacion,
                        'update' => 1));
        } else {
            return redirect()->route('admin.orderestatus.list');
        }
    }



    private function getTraslations($translations, $languagesList) {
        $data = array();

        foreach ($languagesList as $lan) {
            foreach ($translations as $t) {

                if ($lan->locale_key == $t->locale) {
                    $lan['name'] = $t->name;
                    $lan['description'] = $t->description;

                }
            }

            array_push($data, $lan);
        }
        return $data;
    }

}
