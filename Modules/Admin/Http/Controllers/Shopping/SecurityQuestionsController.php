<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers\Shopping;



use Modules\Admin\Entities\Country;
use Modules\CMS\Libraries\Blocks\String_;
use Modules\Shopping\Entities\SecurityQuestions;
use Modules\Shopping\Entities\SecurityQuestionsCountry;
use Modules\Shopping\Entities\SecurityQuestionsTranslation;
use Modules\Shopping\Entities\SecurityQuestionsModel;
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
 * Description of securityquestionsController
 *
 * @author Alan
 */
class SecurityQuestionsController extends Controller {

    public function indexSecurityQuestions($message = "", $validacion = "") {




        //$countries = Country::selectArrayActive();
        $countriesUser = Auth::user()->countries;
        $countries = [];
        foreach ($countriesUser as $uc){

            $countries[$uc->id] = $uc->name;


        }
        $languagesList = Language::where('active', '=', 1)->get();




        $this->layoutData['content'] = View::make('admin::shopping.securityquestions.forms.add', array('countries' => $countries,
                    'languages' => $languagesList,
                    'msg' => $message,
                    'can_add' => Auth::action('securityquestions.add'),
                    'can_delete' => Auth::action('securityquestions.delete'),
                    'can_activate' => Auth::action('securityquestions.activate'),
                    'can_edit' => Auth::action('securityquestions.edit'),
                    'validacion' => $validacion,
                    'add' => 1));
    }

    public function showListSecurityQuestions() {


        $securityquestions = SecurityQuestions::all()->where('delete','=',0);




        $this->layoutData['content'] = View::make('admin::shopping.securityquestions.list', array('securityquestions' => $securityquestions,
                    'can_add' => Auth::action('securityquestions.add'),
                    'can_delete' => Auth::action('securityquestions.active'),
                    'can_edit' => Auth::action('securityquestions.edit'),
        ));
    }

//    public function getListBrands() {
//        return json_encode($this->getBrandTraslations());
//    }

    public function saveSecurityQuestions(Request $request) {
       // dd($request->all());
        if ($request->isMethod('post')) {
                //validación campos globales requeridos
                $v = Validator::make($request->all(), array(
                            'key' => 'required'
                            )
                );


                $attrNamesTrans = array(
                    'key' => trans('admin::shopping.securityquestions.add.keyempty'),

                );
                $v->setAttributeNames($attrNamesTrans);
//            return json_encode($this->validateTraslations($request));

            if ($this->validateTraslations($request)) {
                $validateLanguages = $this->validateTranslationsLanguages($request);

                if($validateLanguages['success']){
                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();
                            //Se almacena en la tabla principal shop_securityquestions


                            $securityquestions = SecurityQuestions::updateOrCreate(
                                ['key_question' => $request->key],
                                []
                            );


                            //Bloque para almacenar en shop_securityquestions_countries
                            foreach ($request->country_id as $country) {
                                $saveSecurityQuestions[] = ['security_questions_id' => $securityquestions->id, 'country_id' => $country,'active' => 1];
                                $availableLanguages[$country]  = $this->validateLanguages($country);
                            }
                            $securityquestions->securityQuestionsCountry()->createMany($saveSecurityQuestions);
                            //Final bloque almacenar shop_registration_references
                            // bloque para almacenar traducciones
                            $valores = $this->setSecurityQuestionsLanguages($request, $securityquestions->id,$availableLanguages);
                            $securityquestions->securityQuestionsTraslations()->createMany($valores);
                            //$this->setSecurityQuestionsLanguages($request, $securityquestions->id);
                            //final bloque almacenar traducciones
                            DB::commit();

                            $message = \Session::flash('info',array('message' => trans('admin::shopping.securityquestions.add.success'),'alertclass' => 'alert-success'));


                            return redirect()->route('admin.securityquestions.list',$message);
                        } catch (Exception $ex) {
                            DB::rollback();
                            $message = \Session::flash('info',array('message' => trans('admin::shopping.securityquestions.add.failed'),'alertclass' => 'alert-danger'));

                            return redirect()->route('admin.securityquestions.list',$message);
                        }
                    }
                    else {
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




    public function updateSecurityQuestions(Request $request) {

        if ($request->isMethod('post')) {

                $v = Validator::make($request->all(), array(
                            'key' => 'required',
                            )
                );
                $attrNamesTrans = array(
                    'key' => trans('admin::shopping.securityquestions.update.emptykey'),

                );
                $v->setAttributeNames($attrNamesTrans);


            if ($this->validateTraslations($request)) {
                $validateLanguages = $this->validateTranslationsLanguages($request);

                if($validateLanguages['success']) {
                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();

                            $securityquestions = SecurityQuestions::find($request->id_security_questions);

                            $securityquestions->key_question = $request->key;
                            $securityquestions->active = 1;


                            foreach ($request->country_id as $country) {
                                $saveSecurityQuestions[] = ['security_questions_id' => $securityquestions->id, 'country_id' => $country, 'active' => 1];
                                $availableLanguages[] = $this->validateLanguages($country);

                            }

                            $securityquestions_languages = $this->setSecurityQuestionsLanguages($request, $securityquestions->id, $availableLanguages);

                            $securityquestions->securityQuestionsCountry()->delete();
                            $securityquestions->securityQuestionsCountry()->createMany($saveSecurityQuestions);
                            $securityquestions->securityQuestionsTraslations()->delete();
                            $securityquestions->securityQuestionsTraslations()->createMany($securityquestions_languages);
                            $securityquestions->save();
                            DB::commit();
                            $message = \Session::flash('info', array('message' => trans('admin::shopping.securityquestions.update.success'), 'alertclass' => 'alert-success'));

                            return redirect()->route('admin.securityquestions.list', $message);
                        } catch (Exception $e) {
                            DB::rollback();
                            $mensage = \Session::flash('info', array('message' => trans('admin::shopping.registrationreferences.add.failed'), 'alertclass' => 'alert-danger'));
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



    private function setSecurityQuestionsLanguages($request, $security_questions_id,$availablelanguages) {

        $securityquestions_languages = array();

        if (count($request->securityquestions_name) > 0 && count($request->securityquestions_locale)) {

            $index = 0;
            foreach ($request->securityquestions_name as $key => $name) {
                $exists = $this->existsKey($request->securityquestions_locale[$index],$availablelanguages);

                if($exists) {
                    $securityQuestionsObj = new SecurityQuestionsModel();
                    $securityQuestionsObj->name = ($name == null) ? '' : $name;
                    $securityQuestionsObj->security_questions_id = $security_questions_id;
                    $securityQuestionsObj->locale = $request->securityquestions_locale[$index];
                    array_push($securityquestions_languages, get_object_vars($securityQuestionsObj));

                }
                $index = $index + 1;
            }
        }
        return $securityquestions_languages;
    }

    public function activeSecurityQuestions(Request $request) {

        $securityquestions = SecurityQuestions::find($request->security_questions_id);

        if ($securityquestions != null) {
            if ($securityquestions->active == true) {
                $securityquestions->active = 0;
                $securityquestions->save();

                //securityQuestionsCountry
                $sqCountries = $securityquestions->securityQuestionsCountry;

                foreach ($sqCountries as $sqc){
                    $sqCountries = SecurityQuestionsCountry::find($sqc->id);
                    $sqCountries->active = 0;
                    $sqCountries->save();
                }


                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            } else {
                $securityquestions->active = 1;
                $securityquestions->save();
                $sqCountries = $securityquestions->securityQuestionsCountry;

                foreach ($sqCountries as $sqc){
                    $sqCountries = SecurityQuestionsCountry::find($sqc->id);
                    $sqCountries->active = 1;
                    $sqCountries->save();
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

    public function deleteSecurityQuestions(Request $request) {

        $securityquestions = SecurityQuestions::find($request->security_questions_id);

        if ($securityquestions != null) {

                $securityquestions->delete = 1;
                $securityquestions->save();
                $response = array(
                    'status' => true,
                    'message' => trans('admin::menu.deleted'),
                );

            return $response;
        } else {
            return "";
        }
    }

    public function CountriesQuestions(Request $request) {

        $questions = SecurityQuestions::find($request->security_questions_id);

        $countries = $questions->securityQuestionsCountry;


        if ($questions != null) {

            $countriesQuestions = [];

            foreach ($countries as $ct){
                $countriesQuestions[$ct['country_id']] = ['estatus'=> $ct['active'],'name' => $ct->country->name];
            }

            return ['success' => true,'message'=> $countriesQuestions];
        } else {
            return ['success' => false,'message'=> trans('admin::shopping.banks.index.emptycountries')];
        }
    }


    public function updatesCountries(Request $request) {

        try {

            DB::beginTransaction();

            $countries = $request->countries_name;


            $questions = SecurityQuestionsCountry::where('security_questions_id', $request->question_identifier)->get();
            foreach ($questions as $qs) {
                //dd(array_key_exists($bk->country_id,$countries),$countries,$bk);
                if (array_key_exists($qs->country_id, $countries)) {
                    $update = SecurityQuestionsCountry::find($qs->id);
                    $update->active = 1;
                    $update->save();
                } else {
                    $update = SecurityQuestionsCountry::find($qs->id);
                    $update->active = 0;
                    $update->save();
                }

            }

            DB::commit();
            $message = \Session::flash('info', array('message' => trans('admin::shopping.banks.index.countriesupdated'), 'alertclass' => 'alert-success'));
            return redirect()->route('admin.securityquestions.list', $message);
        }catch(Exception $e){
            DB::rollback();
            $message = \Session::flash('info',array('message' => trans('admin::shopping.banks.index.failedcountries'),'alertclass' => 'alert-danger'));

            return redirect()->route('admin.securityquestions.list',$message);
        }






    }

    public function getSecurityQuestions($id_security_questions = 0, $message = "", $validacion = "") {
        $securityquestions = SecurityQuestions::find($id_security_questions);

        if ($securityquestions != null) {
            //$countries = Country::selectArrayActive();
            $countriesUser = Auth::user()->countries;
            $countries = [];
            foreach ($countriesUser as $uc){

                $countries[$uc->id] = $uc->name;


            }
            $countriesSelected = SecurityQuestions::find($id_security_questions)->securityQuestionsCountry;
            $languagesList = Language::where('active', '=', 1)->get();
            $languagesList2 = $this->getTraslations($securityquestions->securityQuestionsTraslations, $languagesList);

            $this->layoutData['content'] = View::make('admin::shopping.securityquestions.forms.update', array(
                        'countriesSelected' => array_pluck(
                                $countriesSelected, 'country_id'),
                        'countries' => $countries,
                        'languages' => $languagesList2,
                        'securityquestions' => $securityquestions,
                        'msg' => $message,
                        'validacion' => $validacion,
                        'update' => 1));
        } else {
            return redirect()->route('admin.securityquestions.list');
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

    private function validateTraslations($request) {
        //dd($request->all());
        $totales = count($request->securityquestions_name);
        $cantidadvacios = 0;


        foreach ($request->securityquestions_name as $name) {
            if ($name == null) {
                $cantidadvacios = $cantidadvacios + 1;
            }

        }

        if ($cantidadvacios < $totales) {
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

        foreach ($request->securityquestions_name as $key => $val){
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
    public function validateLanguagesFields($country_id){

        $country= Country::find($country_id);
        $languagesAvailable = [];

        foreach ($country->languagesRelated as $ca){

             array_push($languagesAvailable,$ca->locale_key);
        }

        return $languagesAvailable;

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
