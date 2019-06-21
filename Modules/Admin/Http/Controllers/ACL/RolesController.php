<?php namespace Modules\Admin\Http\Controllers\ACL;

use Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\ACL\UserRoleTranslation;
use Modules\Admin\Entities\Language;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\Admin\Entities\ACL\AdminAction;
use Modules\Admin\Entities\ACL\AdminController;
use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Entities\Page;
use Modules\CMS\Entities\PageGroup;
use Modules\CMS\Entities\PageLang;
use Modules\Admin\Entities\ACL\User;
use Modules\Admin\Entities\ACL\UserRole;
use Request;
use Validator;
use View;

class RolesController extends Controller
{

    private $_child_pages;
    private $_role_permissions;

    public function getIndex()
    {
        $actions = array();
        foreach (AdminAction::where('inherit', '=', 0)->where('edit_based', '=', 0)->where('active', '=', 1)->get() as $action) {
            if (!isset($actions[$action->controller_id])) {
                $actions[$action->controller_id] = array();
            }
            if ($action->action == 'version-publish' && $action->controller_id == 2) {
                $publishing_action_id = $action->id;
            }
            $actions[$action->controller_id][$action->id] = $action;
        }

        // alter actions shown based on site settings
        if (!config('admin.config.publishing') && isset($publishing_action_id)) {
            unset($actions[2][$publishing_action_id]);
        }
        if (config('admin.config.advanced_permissions')) {
            $action = new \stdClass;
            $action->id = -1;
            $action->name = 'Advanced page based permissions';
            $actions[2][] = $action;
        }

       // dd(UserRole::where('admin', '=', 1)->get());
        $roles = array();
        foreach (UserRole::where('admin', '=', 1)->get() as $role) {

            $roles[$role->id] = array('name' => $role->name .' - '. ($role->active == 1 ? trans('admin::roles.view_roles.active') : trans('admin::roles.view_roles.disabled')), 'active' => $role->active);
        }

        $sections = array();
        $group = config('admin.role_sections');
        
        foreach ($group as $id => $name) {
            $sections[$id] = '';
        }

        foreach (AdminController::where('active','=',1)->orderBy('role_order', 'asc')->get() as $index => $controller) {
            $options = '';
            if (!isset($actions[$controller->id])) {
                continue;
            }
            foreach ($actions[$controller->id] as $action) {
                $class = ' controller-' . $controller->controller;
                $options .= View::make('admin::acl.roles.option', array('name' => $action->name, 'id' => $action->id, 'val' => false, 'class' => $class))->render();
            }

            $sections[$controller->role_section] .= View::make('admin::acl.roles.section', array('section' => $controller->role_name, 'options' => $options
                , 'index_tbl_options' => 'section_'.$controller->role_section.'_tbl_'.$index))->render();

        }

        $content = '';
        // Permiso para mostrar las acciones de los roles
        if(Auth::action('roles.actions')){
            foreach ($group as $id => $name) {
                if(!empty($sections[$id])) {
                    $content .= View::make('admin::acl.roles.group', array('group' => $name, 'sections' => $sections[$id], 'index_group' => 'group_' . $id))->render();
                }
            }
        }

        $this->layoutData['content'] = View::make('admin::acl.roles', array('actions' => $content, 'roles' => $roles));

        $roles_modals = array();
        foreach (UserRole::where('admin', '=', 1)->where('active', '=', 1)->get() as $roleMod) {
            $roles_modals[$roleMod->id] = $roleMod->name;
        }
        $copy_roles = $roles_modals;
        $copy_roles[0] = trans('admin::roles.view_roles.none');
        ksort($copy_roles);

        $languagesList = Language::where('active', '=', 1)->get();
        //dd($languagesList);
        $this->layoutData['modals'] = View::make('admin::acl.roles.modals.add'
                , array('roles' => $copy_roles, 'languages' => $languagesList))->render() .  View::make('admin::acl.roles.modals.edit'
                , array('languages' => $languagesList))->render() . View::make('admin::acl.roles.modals.delete'
                , array('roles' => $copy_roles))->render();
    }

    public function postActions($role_id = 0)
    {
        $allowed_actions = array();
        if ($role_id != 0) {
            $role = UserRole::find($role_id);
            if (!empty($role)) {
                foreach ($role->actions as $action) {
                    $allowed_actions[$action->id] = true;
                }
            }
        }
        return json_encode($allowed_actions);
    }

    public function postAdd()
    {
        $arrayExceptPost = array();
        $arrayValidPost = array();
        $data_role_empty = true;

        //For para dejar solo los campos necesarioa en la validacion
        foreach(Request::input('role_data') as $id => $rd ){
            if($rd['name'] == null && $rd['description'] == null){
                $arrayExceptPost[]= 'role_data.'.$id;
            } else {
                $arrayValidPost[] = $id;
                $data_role_empty = false;
            }
        }
        if($data_role_empty) {
            return back()->with(['showModalAdd'=> 1,
                'msg_modal_add_role'=> array('success' => true, 'type_alert' => 'danger', 'message_alert' => trans('admin::roles.msgs.msg_modal_empty_data_role'))]);
        }

        //Reemplazo de parametros POST por los nuevos a validar
        $input = Request::except($arrayExceptPost);
        $v = Validator::make($input, array(
            'role_copy' => 'required|integer',
            'role_data.*.name' => 'required|min:3',
        ));
        $attrNamesTrans = array(
            'role_copy' => trans('admin::roles.modal_add.copy_of'),
            'role_data.*.name' => trans('admin::roles.modal_add.role_name'),
        );
        $v->setAttributeNames($attrNamesTrans);

        if ($v->passes()) {
            $saved_bd = false;
            try {
                DB::beginTransaction();
                $role = new UserRole;
                $role->admin = 1;
                $role->active = 1;
                $role->save();

                $saveRoleTranslations = array();
                foreach ($input['role_data'] as $dataRole) {
                    $dataRole['user_role_id'] = $role->id;
                    $saveRoleTranslations[] = $dataRole;
                }
                $role->roleTranslations()->createMany($saveRoleTranslations);

                $copy = UserRole::find($input['role_copy']);
                if (!empty($copy)) {
                    $copy_actions = array();
                    $controller = AdminController::where('active','=',1)->where('controller', '=', 'roles')->first();
                    foreach ($copy->actions as $action) {
                        // don't copy role permissions
                        if ($controller->id != $action->controller_id) {
                            array_push($copy_actions, $action->id);
                        }
                    }
                    $role->actions()->sync($copy_actions);
                    foreach ($copy->page_actions as $page_action) {
                        $role->page_actions()->attach($page_action->id, ['action_id' => $page_action->pivot->action_id, 'access' => $page_action->pivot->access]);
                    }
                }

                DB::commit();
                $saved_bd = true;
            } catch (\Exception $ex){
                DB::rollback();
            }

            if (!$saved_bd) {
                return back()->with('result',['success' => true, 'type_alert' => 'danger', 'message_alert' => trans('admin::roles.msgs.error_bd')]);
            } else {
                AdminLog::new_log('Role \'' . $role->id . '\' added');
                return back()->with('result',['success' => true, 'type_alert' => 'success', 'message_alert' => trans('admin::roles.msgs.register_saved')]);
            }
        } else {
            return back()->with(['showModalAdd'=> 1, 'arrayValidPost' => $arrayValidPost])->withInput()->withErrors($v);
        }
    }

    public function getEditRoleTranslation($roleId){

        $role_data = array();
        foreach (UserRoleTranslation::where('user_role_id', '=',$roleId)->get() as $id => $rt) {
            $id_lang = Language::where('locale_key', '=', $rt->locale)->first();
            $role_data[$id_lang->id] = array('lang_id' => $id_lang->id, 'name' => $rt->name,
                'description' => $rt->description, 'user_role_id' => $rt->user_role_id, 'locale' => $rt->locale);
        }

        return response()->json($role_data);
    }
    public function postEditRoleTranslations()
    {
        $arrayExceptPost = array();
        $arrayValidPost = array();
        $data_role_empty = true;

        //For para dejar solo los campos necesarioa en la validacion
        foreach(Request::input('role_data') as $id => $rd ){
            if($rd['name'] == null && $rd['description'] == null){
                $arrayExceptPost[]= 'role_data.'.$id;
            } else {
                $arrayValidPost[] = $id;
                $data_role_empty = false;
            }
        }
        if($data_role_empty) {
            return back()->with(['showModalAdd'=> 1, 'id_rol_edit' => Request::input('id_rol_edit'),
                'msg_modal_edit_role'=> array('success' => true, 'type_alert' => 'danger', 'message_alert' => trans('admin::roles.msgs.msg_modal_empty_data_role'))]);
        }

        //Reemplazo de parametros POST por los nuevos a validar
        $input = Request::except($arrayExceptPost);
        $v = Validator::make($input, array(
            'role_data.*.name' => 'required|min:3',
        ));
        $attrNamesTrans = array(
            'role_data.*.name' => trans('admin::roles.modal_add.role_name'),
        );
        $v->setAttributeNames($attrNamesTrans);

        if ($v->passes()) {
            $saved_bd = false;
            try {
                DB::beginTransaction();

                UserRoleTranslation::where('user_role_id', '=', Request::input('id_rol_edit'))->delete();

                DB::table('glob_user_rol_translations')->insert($input['role_data']);

                DB::commit();
                $saved_bd = true;
            } catch (\Exception $ex){
                //$error_bd = $ex->getMessage();
                DB::rollback();
            }
            if (!$saved_bd) {
                return back()->with('result',['success' => true, 'type_alert' => 'danger', 'message_alert' => trans('admin::roles.msgs.error_bd')]);
            } else {
                AdminLog::new_log('Role \'' . Request::input('id_rol_edit') . '\' updateRolesTranslates');
                return back()->with(['result'=> ['success' => true, 'type_alert' => 'success', 'message_alert' => trans('admin::roles.msgs.register_updated')]
                    , 'id_rol_edit' => Request::input('id_rol_edit'),]);
            }
        } else {
            return back()->with(['showModalEdit'=> 1, 'id_rol_edit' => Request::input('id_rol_edit'), 'arrayValidPost' => $arrayValidPost])->withInput()->withErrors($v);
        }
    }

    public function postDelete()
    {
        $v=Validator::make(Request::all(), array(
            'new_role' => 'required|integer|different:id_rol_disable|exists:glob_user_roles,id',
            'id_rol_disable' => 'required'
        ));
        $attrNamesTrans = array(
            'new_role' => trans('admin::roles.modal_disable.new_role'),
        );
        $v->setAttributeNames($attrNamesTrans);

        if ($v->passes()) {
            $saved_bd = false;
            try{

                DB::beginTransaction();

                $role = UserRole::find(Request::input('id_rol_disable'));
                User::where('role_id', '=', Request::input('id_rol_disable'))->update(['role_id' => Request::input('new_role')]);
                $role->active = 0;
                $role->save();

                DB::commit();
                $saved_bd = true;
            } catch (\Exception $ex){

                DB::rollback();
            }

            if (!$saved_bd) {
                return back()->with('result',['success' => true, 'type_alert' => 'danger', 'message_alert' => trans('admin::roles.msgs.error_bd_disable')]);
            } else {
                AdminLog::new_log('Role \'' . $role->id . '\' disabled');

                return back()->with('result',['success' => true, 'type_alert' => 'success', 'message_alert' => trans('admin::roles.msgs.disabled_success')]);
            }
        }
        return back()->with(['showModalDelete'=> 1, 'id_rol_disable' => Request::input('id_rol_disable')])->withInput(Request::all())->withErrors($v);
    }


    public function postActivated()
    {
        $v = Validator::make(Request::all(), array(
            'id_rol_active' => 'required|integer'
        ));
        if ($v->passes()) {
            $role = UserRole::find(Request::input('id_rol_active'));
            if (!empty($role)) {
                $role->active = 1;
                if (!$role->save()) {
                    return back()->with('result',['success' => true, 'type_alert' => 'danger', 'message_alert' =>  trans('admin::roles.msgs.error_bd_activated')]);
                } else {
                    AdminLog::new_log('Role \'' . $role->id . '\' Activated');
                    return back()->with('result',['success' => true, 'type_alert' => 'success', 'message_alert' =>  trans('admin::roles.msgs.activated_success')]);
                }
            }
        }
        return back()->with('result',['success' => true, 'type_alert' => 'danger', 'message_alert' => trans('admin::roles.msgs.role_could_not_activated')]);
    }

    public function postEdit()
    {
        $v = Validator::make(Request::all(), array(
            'role' => 'required|integer',
            'action' => 'required|integer',
            'value' => 'required',
        ));
        if ($v->passes()) {
            $role = UserRole::find(Request::input('role'));
            if (!empty($role)) {
                $action = AdminAction::find(Request::input('action'));
                $controller = AdminController::where('active','=',1)->find($action->controller_id);
                if (!empty($controller) && ($controller->controller != 'roles' || $role->id != Auth::user()->role->id)) {
                    $role->actions()->detach(Request::input('action'));
                    if (Request::input('value') == 'true') {
                        $role->actions()->attach(Request::input('action'));
                    }
                    return 1;
                }
            }
        }
        return 0;
    }


    public function getPages($role_id)
    {
        $this->_role_permissions = UserRole::find($role_id);

        if (!empty($this->_role_permissions)) {

            $pages = Page::orderBy('order', 'asc')->get();
            $this->_child_pages = array();

            foreach ($pages as $page) {
                if (!isset($this->_child_pages[$page->parent])) {
                    $this->_child_pages[$page->parent] = array();
                }
                array_push($this->_child_pages[$page->parent], $page);
            }

            $this->layoutData['content'] = View::make('admin::acl.roles.pages', array('pages' => $this->_print_pages(0), 'role' => $this->_role_permissions->name));
        }
    }

    public function postPages($role_id)
    {
        if (config('admin.config.advanced_permissions')) {

            $page_actions = AdminAction::where('controller_id', '=', 2)->where('inherit', '=', 0)->where('edit_based', '=', 0)->where('active', '=', 1)->get();
            $actionIds = [];
            foreach ($page_actions as $action) {
                $actionIds[$action->action] = $action->id;
            }
            if (!config('admin.config.publishing')) {
                unset($actionIds['version-publish']);
            }

            $pages_permissions = Request::input('page');
            $this->_role_permissions = UserRole::find($role_id);

            // defaults
            $defaults = [];
            foreach ($actionIds as $action => $id) {
                $defaults[$id] = false;
            }
            foreach ($this->_role_permissions->actions as $action) {
                if (array_key_exists($action->id, $defaults)) {
                    $defaults[$action->id] = 1;
                }
            }

            // existing
            $existing = [];
            foreach ($this->_role_permissions->page_actions as $page_permission) {
                if (!isset($existing[$page_permission->pivot->page_id])) {
                    $existing[$page_permission->pivot->page_id] = [];
                }
                $existing[$page_permission->pivot->page_id][$page_permission->pivot->action_id] = $page_permission->pivot->access;
            }

            // save updates
            $pages = Page::where('parent', '>=', '0')->get();
            foreach ($pages as $page) {
                foreach ($actionIds as $action => $action_id) {

                    // get value entered
                    if (isset($pages_permissions[$page->id][$action])) {
                        $value = 'allow';
                    } else {
                        $value = 'deny';
                    }

                    // check if update is required
                    if (isset($existing[$page->id][$action_id])) {
                        if ($defaults[$action_id] && $value == 'allow' || !$defaults[$action_id] && $value == 'deny') {
                            // remove existing
                            $this->_role_permissions->page_actions()->newPivotStatementForId($page->id)->whereActionId($action_id)->delete();
                            if ($page->group_container > 0) {
                                $group = PageGroup::find($page->group_container);
                                foreach ($group->pages as $group_page) {
                                    $this->_role_permissions->page_actions()->newPivotStatementForId($group_page->id)->whereActionId($action_id)->delete();
                                }
                            }

                        } elseif ($existing[$page->id][$action_id] != $value) {
                            // update existing
                            $this->_role_permissions->page_actions()->newPivotStatementForId($page->id)->whereActionId($action_id)->update(['access' => $value]);
                            if ($page->group_container > 0) {
                                $group = PageGroup::find($page->group_container);
                                foreach ($group->pages as $group_page) {
                                    $this->_role_permissions->page_actions()->newPivotStatementForId($group_page->id)->whereActionId($action_id)->update(['access' => $value]);
                                }
                            }
                        }
                    } elseif (!$defaults[$action_id] && $value == 'allow' || $defaults[$action_id] && $value == 'deny') {
                        // add new page action
                        $this->_role_permissions->page_actions()->attach($page->id, ['action_id' => $action_id, 'access' => $value]);
                        if ($page->group_container > 0) {
                            $group = PageGroup::find($page->group_container);
                            foreach ($group->pages as $group_page) {
                                $this->_role_permissions->page_actions()->attach($group_page->id, ['action_id' => $action_id, 'access' => $value]);
                            }
                        }
                    }

                }
            }

            $this->addAlert('success', trans('admin::roles.msgs.page_permission_updated'));
        }

        $this->getPages($role_id);
    }

    private function _print_pages($parent)
    {
        $pages_li = '';
        foreach ($this->_child_pages[$parent] as $child_page) {

            $page_lang = PageLang::preload($child_page->id);
            $sub_pages = "";

            if ($child_page->group_container > 0) {

            } elseif (!empty($this->_child_pages[$child_page->id])) {
                $sub_pages = $this->_print_pages($child_page->id);
            }

            $page_actions = AdminAction::where('controller_id', '=', 2)->where('inherit', '=', 0)->where('edit_based', '=', 0)->where('active', '=', 1)->get();
            $edit_actions = [];
            foreach ($page_actions as $action) {
                if ($action->action == 'index') {
                    $edit_actions['pages'] = false;
                } else {
                    $edit_actions['pages.' . $action->action] = false;
                }
            }

            if (!config('admin.config.publishing')) {
                unset($edit_actions['pages.version-publish']);

            }

            $actions = $this->_role_permissions->processed_actions(['page_id' => $child_page->id]);
            $actions = array_merge($edit_actions, array_intersect_key($actions, $edit_actions));

            $page_actions = [];
            foreach ($actions as $action => $value) {
                if ($action == 'pages') {
                    $page_actions['index'] = $value;
                } else {
                    $page_actions[str_replace('pages.', '', $action)] = $value;
                }
            }

            $pages_li .= View::make('admin::acl.roles.pages.li', array('page_lang' => $page_lang, 'sub_pages' => $sub_pages, 'actions' => $page_actions))->render();

        }
        return View::make('admin::acl.roles.pages.ul', array('pages_li' => $pages_li));
    }

}