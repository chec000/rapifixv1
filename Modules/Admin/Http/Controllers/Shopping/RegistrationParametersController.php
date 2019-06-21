<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers\Shopping;



use Modules\Admin\Entities\Country;
use Modules\CMS\Libraries\Blocks\String_;
use Modules\Shopping\Entities\RegistrationParameters;
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
 * Description of registrationparametersController
 *
 * @author Alan
 */
class RegistrationParametersController extends Controller {

    public function indexRegistrationParameters($message = "", $validacion = "") {




        //$countries = Country::selectArrayActive();
        $countriesUser = Auth::user()->countries;
        $countries = [];
        foreach ($countriesUser as $uc){

            $countries[$uc->id] = $uc->name;


        }




        $this->layoutData['content'] = View::make('admin::shopping.registrationparameters.forms.add', array('countries' => $countries,
                    'msg' => $message,
                    'can_add' => Auth::action('registrationparameters.add'),
                    'can_delete' => Auth::action('registrationparameters.delete'),
                    'can_activate' => Auth::action('registrationparameters.activate'),
                    'can_edit' => Auth::action('registrationparameters.edit'),
                    'validacion' => $validacion,
                    'add' => 1));
    }

    public function showListRegistrationParameters() {
        //dd(Auth::user()->countries);

        $registrationparameters = RegistrationParameters::all()->where('delete','=',0);




        $this->layoutData['content'] = View::make('admin::shopping.registrationparameters.list', array('registrationparameters' => $registrationparameters,
                    'can_add' => Auth::action('registrationparameters.add'),
                    'can_delete' => Auth::action('registrationparameters.active'),
                    'can_edit' => Auth::action('registrationparameters.edit'),
        ));
    }

//    public function getListBrands() {
//        return json_encode($this->getBrandTraslations());
//    }

    public function saveRegistrationParameters(Request $request) {
       // dd($request->all());
        if ($request->isMethod('post')) {
                //validación campos globales requeridos
                $v = Validator::make($request->all(), array(
                            'country_id' => 'required',
                            'min_age' => 'required|numeric|min:1|max:100',
                            'max_age' => 'required|numeric|min:1|max:100',
                            'has_documents' => 'required'
                            )
                );


                $attrNamesTrans = array(
                    'country_id' => trans('admin::shopping.registrationparameters.add.countryempty'),
                    'min_age' => trans('admin::shopping.registrationparameters.add.minageempty'),
                    'max_age' => trans('admin::shopping.registrationparameters.add.maxagempty'),
                    'has_documents' => trans('admin::shopping.registrationparameters.add.hasdocumentsempty'),

                );
                $v->setAttributeNames($attrNamesTrans);
//            return json_encode($this->validateTraslations($request));


                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();
                            //Se almacena en la tabla principal shop_registrationparameters

                            $data = RegistrationParameters::updateOrCreate(
                                ['country_id' => $request->country_id],
                                ['country_id' => $request->country_id, 'min_age' => $request->min_age, 'max_age' => $request->max_age, 'has_documents' => $request->has_documents,'active' => 1,'delete' => 0]
                            );

                            DB::commit();

                            $message = \Session::flash('info',array('message' => trans('admin::shopping.registrationparameters.add.success'),'alertclass' => 'alert-success'));


                            return redirect()->route('admin.registrationparameters.list',$message);
                        } catch (Exception $ex) {
                            DB::rollback();
                            $message = \Session::flash('info',array('message' => trans('admin::shopping.registrationparameters.add.failed'),'alertclass' => 'alert-danger'));

                            return redirect()->route('admin.registrationparameters.list',$message);
                        }
                    }
                    else {
                        FormMessage::set($v->messages());
                        $this->indexRegistrationParameters();
                    }

        }

    }




    public function updateRegistrationParameters(Request $request) {

        if ($request->isMethod('post')) {

                $v = Validator::make($request->all(), array(
                        'country_id' => 'required',
                        'min_age' => 'required|numeric|min:1|max:100',
                        'max_age' => 'required|numeric|min:1|max:100',
                        'has_documents' => 'numeric'
                    )
                );
                $attrNamesTrans = array(
                    'country_id' => trans('admin::shopping.registrationparameters.add.countryempty'),
                    'min_age' => trans('admin::shopping.registrationparameters.add.minageempty'),
                    'max_age' => trans('admin::shopping.registrationparameters.add.maxagempty'),
                    'has_documents' => trans('admin::shopping.registrationparameters.add.hasdocumentsempty'),

                );
                $v->setAttributeNames($attrNamesTrans);




                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();

                            $registrationparameters = RegistrationParameters::find($request->id_registration_parameters);

                            $registrationparameters->country_id = $request->country_id;
                            $registrationparameters->min_age = $request->min_age;
                            $registrationparameters->max_age = $request->max_age;
                            $registrationparameters->has_documents = $request->has_documents;
                            $registrationparameters->save();
                            DB::commit();
                            $message = \Session::flash('info', array('message' => trans('admin::shopping.registrationparameters.update.success'), 'alertclass' => 'alert-success'));

                            return redirect()->route('admin.registrationparameters.list', $message);
                        } catch (Exception $e) {
                            DB::rollback();
                            FormMessage::set($v->messages());
                            $this->getRegistrationParameters($request->id_registration_parameters);
                        }
                    } else {
                        FormMessage::set($v->messages());
                        $this->getRegistrationParameters($request->id_registration_parameters);
                    }


        }
    }


    public function activeRegistrationParameters(Request $request) {

        $registrationparameters = RegistrationParameters::find($request->registration_parameters_id);

        if ($registrationparameters != null) {
            if ($registrationparameters->active == true) {
                $registrationparameters->active = 0;
                $registrationparameters->save();
                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            } else {
                $registrationparameters->active = 1;
                $registrationparameters->save();
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

    public function deleteRegistrationParameters(Request $request) {

        $registrationparameters = RegistrationParameters::find($request->registration_parameters_id);

        if ($registrationparameters != null) {

                $registrationparameters->delete = 1;
                $registrationparameters->save();
                $response = array(
                    'status' => true,
                    'message' => trans('admin::menu.deleted'),
                );

            return $response;
        } else {
            return "";
        }
    }

    public function getRegistrationParameters($id_registration_parameters = 0, $message = "", $validacion = "") {
        $registrationparameters = RegistrationParameters::find($id_registration_parameters);


        if ($registrationparameters != null) {
            //$countries = Country::selectArrayActive();
            $countriesUser = Auth::user()->countries;
            $countries = [];
            foreach ($countriesUser as $uc){

                $countries[$uc->id] = $uc->name;


            }
            $countriesSelected = RegistrationParameters::find($id_registration_parameters)->country->id;



            $this->layoutData['content'] = View::make('admin::shopping.registrationparameters.forms.update', array(
                        'countriesSelected' =>$countriesSelected,
                        'countries' => $countries,
                        'registrationparameters' => $registrationparameters,
                        'msg' => $message,
                        'validacion' => $validacion,
                        'update' => 1));
        } else {
            return redirect()->route('admin.registrationparameters.list');
        }
    }









}
