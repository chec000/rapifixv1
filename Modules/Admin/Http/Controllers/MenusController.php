<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers;

/**
 * Description of MenusController
 *
 * @author sergio
 */
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\ACL\AdminMenu;
use Modules\Admin\Entities\ACL\AdminAction;
use Modules\Admin\Entities\Language;
use View;
use Validator;
use Auth;
//use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Libraries\Builder\FormMessage;

class MenusController extends Controller {

    //put your code here

    public function indexMenu($mensage = "") {

        $actions = AdminAction::orderBy('id', 'asc')->get();
        $actionsParent = AdminMenu::where('parent', '=', 0)->get();
        $languagesList = Language::where('active', '=', 1)->get();
        $this->layoutData['content'] = View::make('admin::settings.menus.addMenu', array('languages' => $languagesList,
                    'actions' => $actions,
                    'parents' => $actionsParent,
                    'can_add' => Auth::action('menuadmin.add.get'),
                    'can_delete' => Auth::action('menuadmin.active'),
                    'can_edit' => Auth::action('menuadmin.update'),
                    'msg' => $mensage
        ));
    }

    public function saveMenu(Request $request) {
        if ($request->isMethod('post')) {

            if ($request->isPrincipal == 1 && $request->parent_r == 1) {
                $v = Validator::make($request->all(), array(
                            'icon' => 'required',
                            'name_lang' => 'required',
                            'action' => 'required',
                            'parent' => 'required'
                ));
            } else if ($request->parent_r == 1) {
                $v = Validator::make($request->all(), array(
                            'icon' => 'required',
                            'name_lang' => 'required',
                            'parent' => 'required'
                ));
            } else if ($request->isPrincipal == 1) {
                $v = Validator::make($request->all(), array(
                            'icon' => 'required',
                            'name_lang' => 'required',
                            'action' => 'required',
                ));
            } else {
                $v = Validator::make($request->all(), array(
                            'icon' => 'required',
                            'name_lang' => 'required'
                ));
            }




            $attrNamesTrans = array(
                'icon' => trans('admin::menu.icon'),
            );
            $v->setAttributeNames($attrNamesTrans);
            if ($this->validateTraslations($request)) {
                if ($v->passes()) {
                    try {
                        DB::beginTransaction();
                        $data = ['active' => '1', 'icon' => 'fa fa-' . $request->icon,
                            'order' => ($request->order == null) ? 1 : $request->order,
                            'parent' => ($request->parent == null) ? 0 : $request->parent,
                            'action_id' => ($request->action == null) ? 0 : $request->action];
                        $menu = AdminMenu::create($data);

                        $traslates = $this->getTraslatesMenu($request, $menu->id);
                        if (count($traslates) > 0) {
                            $menu->traslations()->createMany($traslates);
                        }
                        DB::commit();
//                        AdminLog::new_log('Menu \'' . $menu->item_name . '\' added');

                        return redirect()->route('admin.menuadmin.list');
                    } catch (Exception $e) {
                        DB::rollback();
                        $this->indexMenu();
                    }
                } else {
                    FormMessage::set($v->messages());

                    $this->indexMenu();
                }
            } else {
                $mensage = trans('admin::menu.traslates_name');
                $this->indexMenu($mensage);
            }
        }
    }

    public function getMenuById(Request $request) {
  
        $menu = AdminMenu::where('parent', '=', $request->menu_id)->orderBy('order','desc')->get();
        if ($menu !== null) {
            return $menu;
        } else {
            return null;
        }
    }

    public function getListMenus() {
        $menus = AdminMenu::all();

        $this->layoutData['content'] = View::make('admin::settings.menus.list', array('menus' => $menus,
                    'can_add' => Auth::action('users.add'),
                    'can_delete' => Auth::action('users.delete'),
                    'can_edit' => Auth::action('users.edit')));
    }

    private function getTraslatesMenu($request, $id_menu) {
        $traslates = array();
        if (count($request->name_lang) > 0) {
            $i = 0;
            foreach ($request->name_lang as $name) {
                $traslate = ['admin_menu_id' => $id_menu, 'item_desc' => ($request->description[$i] == null) ? '' : $request->description[$i], 'item_name' => ($name == null) ? "" : $name, 'locale' => $request->locale[$i]];
                array_push($traslates, $traslate);
                $i = $i + 1;
            }
        }
        return $traslates;
    }

    public function activeMenu(Request $request) {
        $menu = AdminMenu::find($request->menu_id);
        if ($menu != null) {

            if ($menu->active == true) {
                $menu->active = 0;
                $menu->save();
//                AdminLog::new_log('Menu \'' . $menu->item_name . '\' disabled');
                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            } else {
                $menu->active = 1;
                $menu->save();
//                AdminLog::new_log('Menu \'' . $menu->item_name . '\' enabled');
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

    public function getMenu($id, $mensage = "") {

        $menu = AdminMenu::find($id);
        
        $actions = AdminAction::orderBy('id', 'asc')->get();
        $actionsParent = AdminMenu::where('parent', '=', 0)->get();
        $languagesList = Language::where('active', '=', 1)->get();
        $orders = AdminMenu::orderBy('order', 'asc')->where('parent', '=', $menu->parent)->select('order')->get();

        $languagesList2 = $this->getTraslationsByMenu($menu->translations, $languagesList);
        $this->layoutData['content'] = View::make('admin::settings.menus.update', array('languages' => $languagesList2, 'msg' => $mensage,
                    'actions' => $actions, 'parents' => $actionsParent, 'menu' => $menu, 'orders' => $orders));
    }       

    private function getTraslationsByMenu($translations, $languagesList) {
        $data = array();
        foreach ($languagesList as $lan) {
            foreach ($translations as $t) {
                if ($lan->locale_key == $t->locale) {
                    $lan['item_name'] = $t->item_name;
                }
            }

            array_push($data, $lan);
        }
        return $data;
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

    public function updateMenu(Request $request) {
        if ($request->isMethod('post')) {
            if ($request->isPrincipal == 1 && $request->parent_r == 1) {
                $v = Validator::make($request->all(), array(
                            'icon' => 'required',
                            'name_lang' => 'required',
                            'action' => 'required',
                            'parent' => 'required')
                );
//                dd($request);
            } else if ($request->parent_r == 1) {
                $v = Validator::make($request->all(), array(
                            'icon' => 'required',
                            'name_lang' => 'required',
                            'parent' => 'required'
                                )
                );
            } else if ($request->isPrincipal == 1) {
                $v = Validator::make($request->all(), array(
                            'icon' => 'required',
                            'name_lang' => 'required',
                            'action' => 'required',
                                )
                );
            } else {
                $v = Validator::make($request->all(), array(
                            'icon' => 'required',
                            'name_lang' => 'required'
                                )
                );
            }
//            dd($request);

            $attrNamesTrans = array(
                'icon' => trans('admin::menu.icon'),
                'name_lang' => trans('admin::menu.traslates_name'),
            );
            $v->setAttributeNames($attrNamesTrans);
            if ($this->validateTraslations($request)) {
                if ($v->passes()) {
                    try {
                        DB::beginTransaction();
                        $menu = AdminMenu::find($request->id_menu);
                        if ($menu !== null) {
                            $menu->action_id = ($request->action == null) ? 0 : $request->action;
                            $menu->order = ($request->order == null) ? 0 : $request->order;
                            $menu->icon = $request->icon;
                            $menu->parent = ($request->parent == null) ? 0 : $request->parent;
                            $menu->save();
                            $traslates = $this->getTraslatesMenu($request, $request->id_menu);
                            if (count($traslates) > 0) {
                                $menu->traslations()->delete();
                                $menu->traslations()->createMany($traslates);
                            }
                        }
                        DB::commit();
//                        AdminLog::new_log('Menu \'' . $menu->item_name . '\' updated');
                        return redirect()->route('admin.menuadmin.list');
                    } catch (Exception $ex) {
                        DB::commit();
                        return redirect()->route('admin.menuadmin.list');
                        DB::rollback();
                    }
                } else {
                    FormMessage::set($v->messages());
                    $this->getMenu($request->id_menu);
                }
            } else {
                $mensage = trans('admin::menu.traslates_name');
                $this->getMenu($request->id_menu, $mensage);
            }
        }
    }

}
