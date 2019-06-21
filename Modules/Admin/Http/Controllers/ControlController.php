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
use Modules\Admin\Entities\Language;
use Modules\Admin\Entities\ACL\AdminController;
use View;
use Validator;
use Auth;
//use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Libraries\Builder\FormMessage;

/**
 * Description of ControllerController
 *
 * @author sergio
 */
class ControlController extends Controller {

    //put your code here


    public function getIndex($mesage = "") {
        $languagesList = Language::where('active', '=', 1)->get();
        $this->layoutData['content'] = View::make('admin::settings.controller.addController', array('languages' => $languagesList,
                    'can_add' => Auth::action('controller.add'),
                    'can_delete' => Auth::action('controller.active'),
                    'can_edit' => Auth::action('controller.update'),
                    'sections' => $this->getSections(),
                    'msg' => $mesage
        ));
    }

    private function getSections() {
        $sections = config('admin.role_sections');
        $sectionsArray = array();
        $id = 1;
        foreach ($sections as $section) {
            $data = ['id' => $id, 'section' => $section];
            array_push($sectionsArray, $data);
            $id = $id + 1;
        }
        return $sectionsArray;
    }

    public function saveController(Request $request) {
        if ($request->isMethod('post')) {
            $v = Validator::make($request->all(), array(
                        'controller_alias' => 'required',
                        'rol_section' => 'required',
                            )
            );
            $attrNamesTrans = array(
                'action_alias' => trans('admin::control.controller_alias'),
                'rol_section' => trans('admin::control.rol_section'),
            );
            $v->setAttributeNames($attrNamesTrans);

            if ($v->passes()) {
                if ($this->validateTraslations($request)) {
                    try {
                        DB::beginTransaction();
                        $data = ['active' => '1', 'controller' => $request->controller_alias, 'role_section' => $request->rol_section, 'role_order' => $request->rol_section + 1];
                        $control = AdminController::create($data);
                        $this->getTraslatesController($request, $control->id);
                        $control->traslations()->createMany($this->getTraslatesController($request, $control->id));
                        DB::commit();
//                        AdminLog::new_log('Control \'' . $control->controller . '\' added');
                        return redirect()->route('admin.controller.list');
                    } catch (Exception $ex) {
                        DB::rollback();
                        $this->getIndex();
                    }
                } else {
                    $mensage = trans('admin::control.traslates_name');
                    $this->getIndex($mensage);
                }
            } else {
                FormMessage::set($v->messages());
                $this->getIndex();
            }
        }
    }

    private function getTraslatesController($request, $id_controller) {
        $traslates = array();
        if (count($request->name_lang) > 0) {
            $i = 0;
            foreach ($request->name_lang as $name) {
                $traslate = ['admin_controller_id' => $id_controller, 'role_name' => ($name == null) ? "" : $name, 'locale' => $request->locale[$i]];
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

    public function getController($controller_id, $mesage = "") {
        $controller = AdminController::find($controller_id);

        $languagesList = Language::where('active', '=', 1)->get();
        $traslations = $this->getTraslationsByController($controller->translations, $languagesList);
        $this->layoutData['content'] = View::make('admin::settings.controller.update', array('languages' => $traslations,
                    'can_edit' => Auth::action('controller.update'),
                    'sections' => $this->getSections(),
                    'msg' => $mesage,
                    'controller' => $controller
        ));
    }

    private function getTraslationsByController($translations, $languagesList) {
        $data = array();
        foreach ($languagesList as $lan) {
            foreach ($translations as $t) {
                if ($lan->locale_key == $t->locale) {
                    $lan['item_name'] = $t->role_name;
                }
            }

            array_push($data, $lan);
        }
        return $data;
    }

    public function updateController(Request $request) {
        if ($request->isMethod('post')) {
            $v = Validator::make($request->all(), array(
                        'controller_alias' => 'required',
                        'rol_section' => 'required',
                            )
            );
            $attrNamesTrans = array(
                'action_alias' => trans('admin::control.controller_alias'),
                'rol_section' => trans('admin::control.rol_section'),
            );
            $v->setAttributeNames($attrNamesTrans);
            if ($v->passes()) {

                if ($this->validateTraslations($request)) {
                    try {
                        DB::beginTransaction();
                        $controller = AdminController::find($request->controller_id);
                        $controller->controller = $request->controller_alias;
                        $controller->role_order = $request->role_order;
                        $controller->role_section = $request->rol_section;
                        $controller->active = 1;
                        $controller->save();
                        $traslates = $this->getTraslatesController($request, $request->controller_id);
                        if (count($traslates) > 0) {
                            $controller->traslations()->delete();
                            $controller->traslations()->createMany($traslates);
                        }
                        DB::commit();
//                        AdminLog::new_log('Control \'' . $controller->controller . '\' updated');
                        return redirect()->route('admin.controller.list');
                    } catch (Exception $ex) {
                        $this->getController($request->controller_id);
                    }
                } else {
                    $mensage = trans('admin::control.traslates_name');
                    $this->getController($request->controller_id, $mensage);
                }
            } else {
                FormMessage::set($v->messages());
                $this->getController();
            }
        }
    }

    public function activateController(Request $request) {
        $controller = AdminController::find($request->id_controller);
        if ($controller != null) {
            if ($controller->active == true) {
                $controller->active = 0;
                $controller->save();
//                AdminLog::new_log('Control \'' . $controller->controller . '\' disabled');

                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            } else {
                $controller->active = 1;
                $controller->save();
//                AdminLog::new_log('Control \'' . $controller->controller . '\' enabled');
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

    public function getListController() {
        $menus = AdminController::all();
        $this->getSections();
        $this->layoutData['content'] = View::make('admin::settings.controller.list', array(
                    'controllers' => $menus,
                    'can_add' => Auth::action('users.add'),
                    'sections' => $this->getSections(),
                    'can_delete' => Auth::action('users.delete'),
                    'can_edit' => Auth::action('users.edit')));
    }

}
