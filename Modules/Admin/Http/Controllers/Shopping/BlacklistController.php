<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers\Shopping;



use Http\Message\Authentication;
use Modules\Admin\Entities\Country;
use Modules\CMS\Libraries\Blocks\String_;
use Modules\Admin\Entities\ACL\User;
use Modules\Shopping\Entities\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Language;
use Image;
use phpDocumentor\Reflection\Types\Integer;
use View;
use Validator;
use Auth;
use Modules\CMS\Libraries\Builder\FormMessage;
use Modules\Admin\Http\Controllers\AdminController as Controller;


/**
 * Description of blacklistController
 *
 * @author Alan
 */
class BlacklistController extends Controller {

    public function indexBlacklist($message = "", $validacion = "") {
        $countriesUser = Auth::user()->countries;
        $countries = [];
        foreach ($countriesUser as $uc){
            $countries[$uc->id] = $uc->name;
        }

        $this->layoutData['content'] = View::make('admin::shopping.blacklist.forms.add', [
            'countries'    => $countries,
            'msg'          => $message,
            'can_add'      => Auth::action('blacklist.add'),
            'can_delete'   => Auth::action('blacklist.delete'),
            'can_activate' => Auth::action('blacklist.activate'),
            'can_edit'     => Auth::action('blacklist.edit'),
            'validacion'   => $validacion,
            'add'          => 1
        ]);
    }

    public function showListBlacklist() {
        //dd(Auth::user()->countries);
        $countries = Auth::user()->countries;
        $countriesUser = [];

        foreach ($countries as $c){
            array_push($countriesUser, $c->id);
        }

        $blacklist = Blacklist::where('delete','=',0)
                                     ->wherein('country_id',User::userCountriesPermission())->get();

        $this->layoutData['content'] = View::make('admin::shopping.blacklist.list', array('blacklist' => $blacklist,
                    'can_add' => Auth::action('blacklist.add'),
                    'can_delete' => Auth::action('blacklist.active'),
                    'can_edit' => Auth::action('blacklist.edit'),
        ));
    }

//    public function getListBrands() {
//        return json_encode($this->getBrandTraslations());
//    }

    public function saveBlacklist(Request $request) {
       // dd($request->all());
        if ($request->isMethod('post')) {
                //validación campos globales requeridos
                $v = Validator::make($request->all(), array(
                            'country_id' => 'required',
                            'eo_number' => 'required',

                            )
                );


                $attrNamesTrans = array(
                    'country_id' => trans('admin::shopping.blacklist.add.countryempty'),
                    'eo_number' => trans('admin::shopping.blacklist.add.eo_numberempty'),


                );
                $v->setAttributeNames($attrNamesTrans);
//            return json_encode($this->validateTraslations($request));


                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();
                            //Se almacena en la tabla principal shop_blacklist
                            $data = Blacklist::updateOrCreate(
                                ['eo_number' => $request->eo_number, 'country_id' => $request->country_id],
                                ['country_id' => $request->country_id, 'eo_number' => $request->eo_number,'active' => 1,'delete' => 0]
                            );


                            DB::commit();

                            $message = \Session::flash('info',array('message' => trans('admin::shopping.blacklist.add.success'),'alertclass' => 'alert-success'));


                            return redirect()->route('admin.blacklist.list',$message);
                        } catch (Exception $ex) {
                            DB::rollback();
                            $message = \Session::flash('info',array('message' => trans('admin::shopping.blacklist.add.failed'),'alertclass' => 'alert-danger'));

                            return redirect()->route('admin.blacklist.list',$message);
                        }
                    }
                    else {
                        FormMessage::set($v->messages());
                        $this->indexBlacklist();
                    }

        }

    }




    public function updateBlacklist(Request $request) {

        if ($request->isMethod('post')) {

                $v = Validator::make($request->all(), array(
                        'country_id' => 'required',
                        'eo_number' => 'required',

                    )
                );
                $attrNamesTrans = array(
                    'country_id' => trans('admin::shopping.blacklist.add.countryempty'),
                    'eo_number' => trans('admin::shopping.blacklist.add.eo_numberempty'),


                );
                $v->setAttributeNames($attrNamesTrans);




                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();

                            $blacklist = Blacklist::find($request->id_blacklist);

                            $blacklist->country_id = $request->country_id;
                            $blacklist->eo_number = $request->eo_number;
                            $blacklist->save();
                            
                            DB::commit();
                            $message = \Session::flash('info', array('message' => trans('admin::shopping.blacklist.update.success'), 'alertclass' => 'alert-success'));

                            return redirect()->route('admin.blacklist.list', $message);
                        } catch (Exception $e) {
                            DB::rollback();
                            FormMessage::set($v->messages());
                            $this->getBlacklist($request->id_blacklist);
                        }
                    } else {
                        FormMessage::set($v->messages());
                        $this->getBlacklist($request->id_blacklist);
                    }


        }
    }


    public function activeBlacklist(Request $request) {

        $blacklist = Blacklist::find($request->blacklist_id);

        if ($blacklist != null) {
            if ($blacklist->active == true) {
                $blacklist->active = 0;
                $blacklist->save();
                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            } else {
                $blacklist->active = 1;
                $blacklist->save();
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

    public function deleteBlacklist(Request $request) {

        $blacklist = Blacklist::find($request->blacklist_id);

        if ($blacklist != null) {

                $blacklist->delete = 1;
                $blacklist->save();
                $response = array(
                    'status' => true,
                    'message' => trans('admin::menu.deleted'),
                );

            return $response;
        } else {
            return "";
        }
    }

    public function getBlacklist($id_blacklist = 0, $message = "", $validacion = "") {
        $blacklist = Blacklist::find($id_blacklist);


        if ($blacklist != null) {

            $countriesUser = Auth::user()->countries;
            $countries = [];
            foreach ($countriesUser as $uc){
                $countries[$uc->id] = $uc->name;
            }



            $countriesSelected = Blacklist::find($id_blacklist)->country->id;




            $this->layoutData['content'] = View::make('admin::shopping.blacklist.forms.update', array(
                        'countriesSelected' =>$countriesSelected,
                        'countries' => $countries,
                        'blacklist' => $blacklist,
                        'msg' => $message,
                        'validacion' => $validacion,
                        'update' => 1));
        } else {
            return redirect()->route('admin.blacklist.list');
        }
    }









}
