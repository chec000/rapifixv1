<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers\Shopping;



use Modules\Admin\Entities\Country;
use Modules\Shopping\Entities\RegistrationReferences;
use Modules\Shopping\Entities\RegistrationReferencesCountry;
use Modules\Shopping\Entities\RegistrationReferencesTranslation;
use Modules\Shopping\Entities\RegistrationReferencesModel;
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
 * Description of registrationreferencesController
 *
 * @author Alan
 */
class RegistrationReferencesController extends Controller {

    public function indexRegistrationReferences($message = "", $validacion = "") {




        //$countries = Country::selectArrayActive();
        $countriesUser = Auth::user()->countries;
        $countries = [];
        foreach ($countriesUser as $uc){

            $countries[$uc->id] = $uc->name;


        }
        $languagesList = Language::where('active', '=', 1)->get();

       $this->layoutData['content'] = View::make('admin::shopping.registrationreferences.forms.add', array('countries' => $countries,
                    'languages' => $languagesList,
                    'msg' => $message,
                    'can_add' => Auth::action('registrationreferences.add'),
                    'can_delete' => Auth::action('registrationreferences.delete'),
                    'can_activate' => Auth::action('registrationreferences.activate'),
                    'can_edit' => Auth::action('registrationreferences.edit'),
                    'validacion' => $validacion,
                    'add' => 1));
    }

    public function showListRegistrationReferences() {


        $registrationreferences = RegistrationReferences::all()->where('delete','=',0);




        $this->layoutData['content'] = View::make('admin::shopping.registrationreferences.list', array('registrationreferences' => $registrationreferences,
                    'can_add' => Auth::action('registrationreferences.add'),
                    'can_delete' => Auth::action('registrationreferences.active'),
                    'can_edit' => Auth::action('registrationreferences.edit'),
        ));
    }

//    public function getListBrands() {
//        return json_encode($this->getBrandTraslations());
//    }

    public function saveRegistrationReferences(Request $request) {
       // dd($request->all());
        if ($request->isMethod('post')) {
                //validación campos globales requeridos
                $v = Validator::make($request->all(), array(
                            'key' => 'required'
                            )
                );


                $attrNamesTrans = array(
                    'key' => trans('admin::shopping.registrationreferences.add.keyempty'),

                );
                $v->setAttributeNames($attrNamesTrans);
//            return json_encode($this->validateTraslations($request));

            if ($this->validateTraslations($request)) {
                $validateLanguages = $this->validateTranslationsLanguages($request);

                if($validateLanguages['success']) {
                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();
                            //Se almacena en la tabla principal shop_registrationreferences
                            $data = [
                                'active' => '1',
                                'key_reference' => $request->key,
                                'paises' => $request->country_id];
                            $registrationreferences = RegistrationReferences::create($data);
                            //Bloque para almacenar en shop_registrationreferences_countries
                            foreach ($request->country_id as $country) {
                                $saveRegistrationReferences[] = ['registration_references_id' => $registrationreferences->id, 'country_id' => $country, 'active' => 1];
                                $availableLanguages[] = $this->validateLanguages($country);
                            }
                            $registrationreferences->registrationReferencesCountry()->createMany($saveRegistrationReferences);
                            //Final bloque almacenar shop_registration_references
                            // bloque para almacenar traducciones
                            $valores = $this->setRegistrationReferencesLanguages($request, $registrationreferences->id, $availableLanguages);
                            $registrationreferences->registrationReferencesTraslations()->createMany($valores);
                            //$this->setRegistrationReferencesLanguages($request, $registrationreferences->id);
                            //final bloque almacenar traducciones
                            DB::commit();

                            $message = \Session::flash('info', array('message' => trans('admin::shopping.registrationreferences.add.success'), 'alertclass' => 'alert-success'));


                            return redirect()->route('admin.registrationreferences.list', $message);
                        } catch (Exception $ex) {
                            DB::rollback();
                            $message = \Session::flash('info', array('message' => trans('admin::shopping.registrationreferences.add.failed'), 'alertclass' => 'alert-danger'));

                            return redirect()->route('admin.registrationreferences.list', $message);
                        }
                    }
                    else {
                        //FormMessage::set($v->messages());
                        $mensage = $v->messages();
                        return redirect()->back()
                            ->withInput($request->all())
                            ->withErrors([$mensage]);
                    }
                }else{
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
        $totales = count($request->registrationreferences_name);
        $cantidad = 0;

        foreach ($request->registrationreferences_name as $name) {
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


        //se revisan los idiomas disponibles por pais
        foreach ($request->country_id as $country) {

            $availableLanguages[$country]  = $this->validateLanguagesFields($country);

        }


        //se crea un array con los idiomas unicos
        $idiomasSeparados = [];
        foreach ($availableLanguages as $key => $al){
            foreach ($al as $aa){
                //var_dump(in_array($aa,$idiomasSeparados));
                if(!in_array($aa,$idiomasSeparados)){
                    $idiomasSeparados[] = $aa;
                }
            }
        }

        foreach ($request->registrationreferences_name as $key => $val){
            if(!empty($val)){
                if(in_array($key,$idiomasSeparados)){
                    $contadorIdiomas = $contadorIdiomas + 1;
                }
            }
        }

        $cantidadRequeridaTraducciones = count($idiomasSeparados);

        if($contadorIdiomas < $cantidadRequeridaTraducciones){
            //return false;
            return ['success' => false,'message'=> $idiomasSeparados];
        }

        return ['success' => true,'message'=> ''];
    }

    public function validateLanguagesFields($country_id){

        $country= Country::find($country_id);
        $languagesAvailable = [];

        foreach ($country->languagesRelated as $ca){

            array_push($languagesAvailable,$ca->locale_key);
        }

        return $languagesAvailable;

    }

    public function updateRegistrationReferences(Request $request) {

        if ($request->isMethod('post')) {

                $v = Validator::make($request->all(), array(
                            'key' => 'required',
                            )
                );
                $attrNamesTrans = array(
                    'key' => trans('admin::shopping.registrationreferences.update.emptykey'),

                );
                $v->setAttributeNames($attrNamesTrans);


            if ($this->validateTraslations($request)) {
                $validateLanguages = $this->validateTranslationsLanguages($request);

                if($validateLanguages['success']) {
                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();

                            $registrationreferences = RegistrationReferences::find($request->id_registration_references);

                            $registrationreferences->key_reference = $request->key;
                            $registrationreferences->active = 1;


                            foreach ($request->country_id as $country) {
                                $saveRegistrationReferences[] = ['registration_references_id' => $registrationreferences->id, 'country_id' => $country, 'active' => 1];
                                $availableLanguages[] = $this->validateLanguages($country);

                            }

                            $registrationreferences_languages = $this->setRegistrationReferencesLanguages($request, $registrationreferences->id, $availableLanguages);

                            $registrationreferences->registrationReferencesCountry()->delete();
                            $registrationreferences->registrationReferencesCountry()->createMany($saveRegistrationReferences);
                            $registrationreferences->registrationReferencesTraslations()->delete();
                            $registrationreferences->registrationReferencesTraslations()->createMany($registrationreferences_languages);
                            $registrationreferences->save();
                            DB::commit();
                            $message = \Session::flash('info', array('message' => trans('admin::shopping.registrationreferences.update.success'), 'alertclass' => 'alert-success'));

                            return redirect()->route('admin.registrationreferences.list', $message);
                        } catch (Exception $e) {
                            DB::rollback();
                            $mensage = \Session::flash('info', array('message' => trans('admin::shopping.registrationreferences.add.failed'), 'alertclass' => 'alert-danger'));
                            return redirect()->back()
                                ->withInput($request->all())
                                ->withErrors([$mensage]);
                        }
                    }
                    else {
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

                    //$this->indexRegistrationReferences($mensage);

                    return redirect()->back()
                           ->withInput($request->all())
                           ->withErrors([$mensage]);
                }
            } else {
                $mensage = trans('admin::menu.traslates_name');
                //$this->getRegistrationReferences($request->id_registration_references, $mensage);

                return redirect()->back()
                                 ->withInput($request->all())
                                 ->withErrors([$mensage]);
            }
        }
    }

    private function setRegistrationReferencesLanguages($request, $registration_references_id,$availablelanguages) {

        $registrationreferences_languages = array();

        if (count($request->registrationreferences_name) > 0 && count($request->registrationreferences_locale)) {

            $index = 0;
            foreach ($request->registrationreferences_name as $name) {
                $exists = $this->existsKey($request->registrationreferences_locale[$index],$availablelanguages);

                if($exists) {
                    $registrationReferencesObj = new RegistrationReferencesModel();
                    $registrationReferencesObj->name = ($name == null) ? '' : $name;
                    $registrationReferencesObj->registration_references_id = $registration_references_id;
                    $registrationReferencesObj->locale = $request->registrationreferences_locale[$index];
                    array_push($registrationreferences_languages, get_object_vars($registrationReferencesObj));

                }
                $index = $index + 1;
            }
        }
        return $registrationreferences_languages;
    }

    public function activeRegistrationReferences(Request $request) {

        $registrationreferences = RegistrationReferences::find($request->registration_references_id);

        if ($registrationreferences != null) {
            if ($registrationreferences->active == true) {
                $registrationreferences->active = 0;
                $registrationreferences->save();


                //registrationReferencesCountry
                $rfCountries = $registrationreferences->registrationReferencesCountry;

                foreach ($rfCountries as $rfc){
                    $rfCountries = RegistrationReferencesCountry::find($rfc->id);
                    $rfCountries->active = 0;
                    $rfCountries->save();
                }


                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            }
            else {
                $registrationreferences->active = 1;
                $registrationreferences->save();

                $rfCountries = $registrationreferences->registrationReferencesCountry;

                foreach ($rfCountries as $rfc){
                    $rfCountries = RegistrationReferencesCountry::find($rfc->id);
                    $rfCountries->active = 1;
                    $rfCountries->save();
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

    public function deleteRegistrationReferences(Request $request) {

        $registrationreferences = RegistrationReferences::find($request->registration_references_id);

        if ($registrationreferences != null) {

                $registrationreferences->delete = 1;
                $registrationreferences->save();
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

        $references = RegistrationReferences::find($request->registration_id);
        $countries = $references->registrationReferencesCountry;


        if ($references != null) {

            $countriesReferences = [];

            foreach ($countries as $ct){
                $countriesReferences[$ct['country_id']] = ['estatus'=> $ct['active'],'name' => $ct->country->name];
            }

            return ['success' => true,'message'=> $countriesReferences];
        } else {
            return ['success' => false,'message'=> trans('admin::shopping.banks.index.emptycountries')];
        }
    }


    public function updatesCountries(Request $request) {

        try {

            DB::beginTransaction();

            $countries = $request->countries_name;


            $references = RegistrationReferencesCountry::where('registration_references_id', $request->reference_identifier)->get();
            foreach ($references as $rf) {
                //dd(array_key_exists($bk->country_id,$countries),$countries,$bk);
                if (array_key_exists($rf->country_id, $countries)) {
                    $update = RegistrationReferencesCountry::find($rf->id);
                    $update->active = 1;
                    $update->save();
                } else {
                    $update = RegistrationReferencesCountry::find($rf->id);
                    $update->active = 0;
                    $update->save();
                }

            }

            DB::commit();
            $message = \Session::flash('info', array('message' => trans('admin::shopping.banks.index.countriesupdated'), 'alertclass' => 'alert-success'));
            return redirect()->route('admin.registrationreferences.list', $message);
        }catch(Exception $e){
            DB::rollback();
            $message = \Session::flash('info',array('message' => trans('admin::shopping.banks.index.failedcountries'),'alertclass' => 'alert-danger'));

            return redirect()->route('admin.registrationreferences.list',$message);
        }






    }



    public function getRegistrationReferences($id_registration_references = 0, $message = "", $validacion = "") {
        $registrationreferences = RegistrationReferences::find($id_registration_references);

        if ($registrationreferences != null) {
            $countries = Country::selectArrayActive();
            $countriesSelected = RegistrationReferences::find($id_registration_references)->registrationReferencesCountry;
            $languagesList = Language::where('active', '=', 1)->get();
            $languagesList2 = $this->getTraslations($registrationreferences->registrationReferencesTraslations, $languagesList);

            $this->layoutData['content'] = View::make('admin::shopping.registrationreferences.forms.update', array(
                        'countriesSelected' => array_pluck(
                                $countriesSelected, 'country_id'),
                        'countries' => $countries,
                        'languages' => $languagesList2,
                        'registrationreferences' => $registrationreferences,
                        'msg' => $message,
                        'validacion' => $validacion,
                        'update' => 1));
        } else {
            return redirect()->route('admin.registrationreferences.list');
        }
    }



    private function getTraslations($translations, $languagesList) {
        $data = array();

        foreach ($languagesList as $lan) {
            foreach ($translations as $t) {

                if ($lan->locale_key == $t->locale) {
                    $lan['name'] = $t->name;


                }
            }

            array_push($data, $lan);
        }
        return $data;
    }

    public function existsKey($lankey,$datos){


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

}
