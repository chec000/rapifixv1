<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers\Shopping;



use Modules\Admin\Entities\Country;
use Modules\CMS\Libraries\Blocks\String_;
use Modules\Shopping\Entities\Bank;
use Modules\Shopping\Entities\BankCountry;
use Modules\Shopping\Entities\BankTranslation;
use Modules\Shopping\Entities\banksModel;
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
 * Description of banksController
 *
 * @author Alan
 */
class BanksController extends Controller {

    public function indexBanks($message = "", $validacion = "") {




        //$countries = Country::selectArrayActive();
        $countriesUser = Auth::user()->countries;
        $countries = [];
        foreach ($countriesUser as $uc){

            $countries[$uc->id] = $uc->name;


        }
        $languagesList = Language::where('active', '=', 1)->get();




        $this->layoutData['content'] = View::make('admin::shopping.banks.forms.add', array('countries' => $countries,
                    'languages' => $languagesList,
                    'msg' => $message,
                    'can_add' => Auth::action('banks.add'),
                    'can_delete' => Auth::action('banks.delete'),
                    'can_activate' => Auth::action('banks.activate'),
                    'can_edit' => Auth::action('banks.edit'),
                    'validacion' => $validacion,
                    'add' => 1));
    }

    public function showListBanks() {


        $banks = Bank::all()->where('delete','=',0);




        $this->layoutData['content'] = View::make('admin::shopping.banks.list', array('banks' => $banks,
                    'can_add' => Auth::action('banks.add'),
                    'can_delete' => Auth::action('banks.active'),
                    'can_edit' => Auth::action('banks.edit'),
        ));
    }

//    public function getListBrands() {
//        return json_encode($this->getBrandTraslations());
//    }

    public function saveBanks(Request $request) {
       //dd($request->all());
        if ($request->isMethod('post')) {
                //validación campos globales requeridos
                $v = Validator::make($request->all(), array(
                            'bank_key' => 'required|max:30',
                            'url'         => 'required|max:70',


                            )
                );


                $attrNamesTrans = array(
                    'bank_key' => trans('admin::shopping.banks.add.bank_keyempty'),
                    'url' => trans('admin::shopping.banks.add.urlempty'),


                );
                $v->setAttributeNames($attrNamesTrans);
//            return json_encode($this->validateTraslations($request));

            if ($this->validateTraslations($request)) {
                $validateLanguages = $this->validateTranslationsLanguages($request);

                if($validateLanguages['success']){
                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();
                            //Se almacena en la tabla principal shop_banks


                            $banks = Bank::updateOrCreate(
                                ['bank_key' => $request->bank_key],
                                ['bank_key' => $request->bank_key, 'url' => $request->url,'logo'=>$request->logo,'active' => 1,'delete' => 0]
                            );


                            //Bloque para almacenar en shop_securityquestions_countries
                            foreach ($request->country_id as $country) {
                                $saveBanks = [];
                                if(!$this->existsCountry($banks->id,$country)){
                                    $saveBanks[] = ['bank_id' => $banks->id, 'country_id' => $country,'active' => 1];
                                }

                                $availableLanguages[$country]  = $this->validateLanguage($country);
                            }

                            $banks->banksCountry()->createMany($saveBanks);
                            
                            $valores = $this->setBanksLanguages($request, $banks->id,$availableLanguages);
                            $banks->banksTraslations()->createMany($valores);

                            DB::commit();

                            $message = \Session::flash('info',array('message' => trans('admin::shopping.banks.add.success'),'alertclass' => 'alert-success'));


                            return redirect()->route('admin.banks.list',$message);
                        } catch (Exception $ex) {
                            DB::rollback();
                            $message = \Session::flash('info',array('message' => trans('admin::shopping.banks.add.failed'),'alertclass' => 'alert-danger'));

                            return redirect()->route('admin.banks.list',$message);
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




    public function updateBanks(Request $request) {
        //dd($request->all());
        if ($request->isMethod('post')) {

                $v = Validator::make($request->all(), array(
                                'bank_key' => 'required|max:30',
                                'url'         => 'required|max:70',
                                'country_id'  => 'required',
                            )
                );
                $attrNamesTrans = array(
                    'bank_key' => trans('admin::shopping.banks.add.bank_keyempty'),
                    'url' => trans('admin::shopping.banks.add.urlempty'),
                    'country_id' => trans('admin::shopping.banks.add.country_idempty'),

                );
                $v->setAttributeNames($attrNamesTrans);


            if ($this->validateTraslations($request)) {
                $validateLanguages = $this->validateTranslationsLanguages($request);

                if($validateLanguages['success']) {
                    if ($v->passes()) {
                        try {

                            DB::beginTransaction();

                            $banks = Bank::find($request->id_bank);

                            $banks->bank_key = $request->bank_key;
                            $banks->url = $request->url;
                            $banks->logo = $request->logo;

                            $banks->last_modifier_id = Auth::user()->id;



                            foreach ($request->country_id as $country) {
                                $saveBanks[] = ['bank_id' => $banks->id, 'country_id' => $country, 'active' => 1];
                                $availableLanguages[] = $this->validateLanguage($country);

                            }
                            $banks->banksCountry()->delete();
                            $banks->banksCountry()->createMany($saveBanks);
                            $banks->save();
                            $banks->banksTraslations()->delete();
                            $banks_languages = $this->setBanksLanguages($request, $banks->id, $availableLanguages);


                            //$banks->banksTraslations()->createMany($banks_languages);





                            DB::commit();
                            $message = \Session::flash('info', array('message' => trans('admin::shopping.banks.update.success'), 'alertclass' => 'alert-success'));

                            return redirect()->route('admin.banks.list', $message);
                        } catch (Exception $e) {
                            DB::rollback();
                            $mensage = \Session::flash('info', array('message' => trans('admin::shopping.banks.add.failed'), 'alertclass' => 'alert-danger'));
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



    private function setBanksLanguages($request, $bank_id,$availablelanguages) {

        $banks_languages = array();

        if (count($request->banks_name) > 0 && count($request->banks_locale)) {

            $index = 0;
            $banktrans = Bank::find($bank_id);

            foreach ($request->banks_name as $key => $name) {


                $hasRecords = $this->hasRecords($request->banks_locale[$index],$bank_id);
                if(!$hasRecords){
                    $exists = $this->existsKey($request->banks_locale[$index],$availablelanguages);

                    if($exists) {
                        /* $banksObj = new BanksModel();
                        $banksObj->name = ($name == null) ? '' : $name;
                        $banksObj->description = $request->banks_description[$index];
                        $banksObj->bank_id = $bank_id;
                        $banksObj->locale = $request->banks_locale[$index];
                        array_push($banks_languages, get_object_vars($banksObj)); */

                        $banktrans->translateorNew($request->banks_locale[$index])->name = $name;
                        $banktrans->translateorNew($request->banks_locale[$index])->description = $request->banks_description[$key];
                        $banktrans->save();


                    }
                }

                $index = $index + 1;
            }
        }
        return $banks_languages;
    }

    public function activeBanks(Request $request) {

        $banks = Bank::find($request->bank_id);


        if ($banks != null) {
            if ($banks->active == true) {
                $banks->active = 0;
                $banks->save();

                //se procede a inactivar todos los de banks countries
                $bankCountries = $banks->banksCountry;

                foreach ($bankCountries as $bkc){
                    $bankCountry = BankCountry::find($bkc->id);
                    $bankCountry->active = 0;
                    $bankCountry->save();
                }


                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            } else {
                $banks->active = 1;
                $banks->save();
                //se procede a activar todos los de banks countries
                $bankCountries = $banks->banksCountry;

                foreach ($bankCountries as $bkc){
                    $bankCountry = BankCountry::find($bkc->id);
                    $bankCountry->active = 1;
                    $bankCountry->save();
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

    public function deleteBanks(Request $request) {

        $banks = Bank::find($request->bank_id);

        if ($banks != null) {

                $banks->delete = 1;
                $banks->save();
                $response = array(
                    'status' => true,
                    'message' => trans('admin::menu.deleted'),
                );

            return $response;
        } else {
            return "";
        }
    }

    public function CountriesBank(Request $request) {

        $banks = Bank::find($request->bank_id);
        $countries = $banks->banksCountry;


        if ($banks != null) {

           $countriesBank = [];

           foreach ($countries as $ct){
               $countriesBank[$ct['country_id']] = ['estatus'=> $ct['active'],'name' => $ct->country->name];
           }

            return ['success' => true,'message'=> $countriesBank];
        } else {
            return ['success' => false,'message'=> trans('admin::shopping.banks.index.emptycountries')];
        }
    }


    public function updatesCountries(Request $request) {

        try {

            DB::beginTransaction();

            $countries = $request->countries_name;


            $banks = BankCountry::where('banks_id', $request->bank_identifier)->get();
            foreach ($banks as $bk) {
                //dd(array_key_exists($bk->country_id,$countries),$countries,$bk);
                if (array_key_exists($bk->country_id, $countries)) {
                    $update = BankCountry::find($bk->id);
                    $update->active = 1;
                    $update->save();
                } else {
                    $update = BankCountry::find($bk->id);
                    $update->active = 0;
                    $update->save();
                }

            }

            DB::commit();
            $message = \Session::flash('info', array('message' => trans('admin::shopping.banks.index.countriesupdated'), 'alertclass' => 'alert-success'));
            return redirect()->route('admin.banks.list', $message);
        }catch(Exception $e){
            DB::rollback();
            $message = \Session::flash('info',array('message' => trans('admin::shopping.banks.index.failedcountries'),'alertclass' => 'alert-danger'));

            return redirect()->route('admin.banks.list',$message);
        }






    }


    public function getBanks($id_bank = 0, $message = "", $validacion = "") {
        $banks = Bank::find($id_bank);


        if ($banks != null) {
            $countriesUser = Auth::user()->countries;
            $countries = [];
            foreach ($countriesUser as $uc){

                $countries[$uc->id] = $uc->name;


            }
            $countriesSelected = Bank::find($id_bank)->banksCountry;


            $languagesList = Language::where('active', '=', 1)->get();
            $languagesList2 = $this->getTraslations($banks->banksTraslations, $languagesList);


            $this->layoutData['content'] = View::make('admin::shopping.banks.forms.update', array(
                        'countriesSelected' => array_pluck(
                            $countriesSelected, 'country_id'),
                        'countries' => $countries,
                        'languages' => $languagesList2,
                        'banks' => $banks,
                        'msg' => $message,
                        'validacion' => $validacion,
                        'update' => 1));
        } else {
            return redirect()->route('admin.banks.list');
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

    private function validateTraslations($request) {
        //dd($request->all());
        $totales = count($request->banks_name);
        $cantidadvacios = 0;


        foreach ($request->banks_name as $name) {
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

        foreach ($request->banks_name as $key => $val){
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

    public function hasRecords($lankey,$id_bank){

        $bank = Bank::find($id_bank);
        $banks = $bank->banksTraslations;


        foreach ($banks as $bk){

            if($bk->locale == $lankey){
                return true;
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


    public function validateLanguage($country_id){

        $country= Country::find($country_id);
        $languagesAvailable = [];
        foreach ($country->languagesRelated as $ca){

            array_push($languagesAvailable,$ca->locale_key);

        }

        return $languagesAvailable;

    }

    public function existsCountry($id_bank,$country){

        $bank = Bank::find($id_bank);
        $banks = $bank->banksCountry;


        foreach ($banks as $bk){

            if($bk->country_id == $country){
                return true;
            }

        }




        return false;
    }

}
