<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Http\Controllers\AdminController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\ACL\AdminController;
use Modules\Admin\Entities\ACL\AdminAction;
use Modules\Admin\Entities\Language;
use View;
use Validator;
use Auth;
//use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Libraries\Builder\FormMessage;

/**
 * Description of ActionController
 *
 * @author sergio
 */
class ActionController extends Controller {

    //put your code here
    public function indexFunction($massage = "") {

        $controllers = AdminController::where('active', '=', 1)->get();
        $actions = AdminAction::orderBy('id', 'asc')->get();
        $languagesList = Language::where('active', '=', 1)->get();
        $this->layoutData['content'] = View::make('admin::settings.actions.addAction', array('languages' => $languagesList,
                    'actions' => $actions,
                    'controllers' => $controllers,
                    'can_add' => Auth::action('action.add'),
                    'msg' => $massage
        ));
    }

    public function saveFunction(Request $request) {

        if ($request->isMethod('post')) {
            if ($request->inherit > 0) {

                $v = Validator::make($request->all(), array(
                            'action_alias' => 'required',
                            'controller' => 'required',
                            'parent' => 'required'
                                )
                );
            } else {

                $v = Validator::make($request->all(), array(
                            'action_alias' => 'required',
                            'controller' => 'required'
                                )
                );
            }

            $attrNamesTrans = array(
                'action_alias' => trans('admin::action.action_alias'),
                'controller' => trans('admin::action.action_alias'),
                'parent' => trans('admin::action.action_alias')
            );
            $v->setAttributeNames($attrNamesTrans);
            if ($this->validateTraslations($request)) {

                if ($v->passes()) {
                    try {
                        DB::beginTransaction();
                        $data = ['active' => '1', 'action' => $request->action_alias,
                            'action_others' => $request->action_others,
                            'controller_id' => $request->controller,
                            'edit_based' => ($request->edit_based == null) ? 0 : $request->parent,
                            'inherit' => ($request->parent == 1) ? $request->dependent_action : $request->parent];
                        $action = AdminAction::create($data);
                        $action->traslations()->createMany($this->getTraslatesAction($request, $action->id));
                        DB::commit();

//                        AdminLog::new_log('Action \'' . $action->action . '\' added');
                        $this->listFunction();
                    } catch (Exception $ex) {
                        DB::rollback();
                        $this->indexFunction();
                    }
                } else {
                    FormMessage::set($v->messages());
                    $this->indexFunction();
                }
            } else {
                $mensage = trans('admin::menu.traslates_name');
                $this->indexFunction($mensage);
            }
        }

        //rol_section,controller,action_alias
    }

    private function getTraslatesAction($request, $id_action) {
        $traslates = array();
        if (count($request->name_lang) > 0) {

            $i = 0;
            foreach ($request->name_lang as $name) {
                $traslate = ['admin_controller_id' => $id_action,
                    'name' => ($name == null) ? "" : $name,
                    'locale' => $request->locale[$i],
                    'about' => $request->description[$i]];
                array_push($traslates, $traslate);
                $i = $i + 1;
            }
        }
        return $traslates;
    }

    private function validateTraslations($request) {
        $totales = count($request->name_lang);
        $cantidad = 0;
        foreach ($request->name_lang as $name) {
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

    public function listFunction() {
        $actions = AdminAction::all();
      
        $this->layoutData['content'] = View::make('admin::settings.actions.list', array('actions' => $actions,
                    'can_add' => Auth::action('action.add'),
                    'can_delete' => Auth::action('action.active'),
                    'can_edit' => Auth::action('action.update')));
    }

    public function activateFunction(Request $request) {
        $action = AdminAction::find($request->action_id);
        if ($action != null) {

            if ($action->active == true) {
                $action->active = 0;
                $action->save();
//                AdminLog::new_log('Action \'' . $action->action . '\' disabled');
                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            } else {
                $action->active = 1;
                $action->save();
//                AdminLog::new_log('Action \'' . $action->action . '\' enabled');
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

    public function getFunction($function_id, $message = "") {

        $action = AdminAction::find($function_id);
        $controllers = AdminController::where('active', '=', 1)->get();
        $actions = AdminAction::orderBy('id', 'asc')->get();
        $languagesList = Language::where('active', '=', 1)->get();
        $languagesTraslates = $this->getTraslationsByAction($action->translations, $languagesList);
        $this->layoutData['content'] = View::make('admin::settings.actions.update', array('languages' => $languagesTraslates,
                    'actions' => $actions,
                    'action' => $action,
                    'controllers' => $controllers,
                    'can_edit' => Auth::action('action.update'),
                    'msg' => $message
        ));
    }

    private function getTraslationsByAction($translations, $languagesList) {
        $data = array();
        foreach ($languagesList as $lan) {
            foreach ($translations as $t) {
                if ($lan->locale_key == $t->locale) {
                    $lan['item_name'] = $t->name;
                    $lan['description'] = $t->about;
                }
            }

            array_push($data, $lan);
        }
        return $data;
    }

    public function updateFunction(Request $request) {
        if ($request->isMethod('post')) {

            if ($request->inherit > 0) {

                $v = Validator::make($request->all(), array(
                            'action_alias' => 'required',
                            'controller' => 'required',
                            'parent' => 'required'
                                )
                );
            } else {

                $v = Validator::make($request->all(), array(
                            'action_alias' => 'required',
                            'controller' => 'required'
                                )
                );
            }


            $attrNamesTrans = array(
                'action_alias' => trans('admin::action.controller'),
            );
            $v->setAttributeNames($attrNamesTrans);
            if ($this->validateTraslations($request)) {

                if ($v->passes()) {
                    try {
                        DB::beginTransaction();
                        $action = AdminAction::find($request->id_action);
                        $action->controller_id = $request->controller;
                        $action->action = $request->action_alias;
                        $action->action_others = $request->action_others;
                        $action->edit_based = ($request->edit_based == null) ? 0 : $request->parent;
                        $action->active = 1;
                        $action->inherit = ($request->parent == 1) ? $request->dependent_action : $request->parent;
                        $action->traslations()->delete();
                        $action->traslations()->createMany($this->getTraslatesAction($request, $action->id_action));
                        $action->save();
                        DB::commit();

//                        AdminLog::new_log('Action \'' . $action->action . '\' updated');
                        return redirect()->route('admin.action.list');
                    } catch (Exception $ex) {
                        DB::rollback();
                        $message = trans('admin::menu.traslates_name');
                        $this->getFunction($request->id_action, $message);
                    }
                } else {
                    FormMessage::set($v->messages());
                    $this->getFunction($request->id_action);
                }
            } else {
                $message = trans('admin::menu.traslates_name');
                $this->getFunction($request->id_action, $message);
            }
        }
    }

}
