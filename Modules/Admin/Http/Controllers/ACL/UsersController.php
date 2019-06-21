<?php namespace Modules\Admin\Http\Controllers\ACL;

use Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\BrandCountry;
use Modules\Admin\Entities\Language;
use Modules\CMS\Libraries\Builder\FormMessage;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Entities\AdminLog;
use Modules\Admin\Entities\ACL\User;
use Modules\Admin\Entities\ACL\UserRole;
use Hash;
use Mail;
use Request;
use Response;
use Validator;
use View;

class UsersController extends Controller
{

    public function getIndex()
    {
        //$users = User::join('glob_user_roles', 'glob_user_roles.id', '=', 'glob_users.role_id')->select(array('glob_users.id', 'glob_users.email', 'glob_user_roles.name', 'glob_users.active'))->get();
        //$users = User::join('glob_user_roles', 'glob_user_roles.id', '=', 'glob_users.role_id')->select(array('glob_users.id', 'glob_users.email', 'glob_users.active'))->get();
        $users = User::where('delete', 0)->get();
        $this->layoutData['modals']  = View::make('admin::modals.general.delete_item').View::make('admin::shopping.pool.modals.confirm');
        $this->layoutData['content'] = View::make('admin::acl.users', array(
            'users'      => $users,
            'can_add'    => Auth::action('users.add'),
            'can_delete' => Auth::action('users.delete'),
            'can_edit'   => Auth::action('users.edit'),
            'can_remove' => Auth::action('users.remove'),
            )
        );
    }

    public function postEdit($userId = 0, $action = null)
    {
        //var_dump(Request::all()); exit();
        $user = User::find($userId);
        $authUser = Auth::user();
        if (!empty($user) && $authUser->role->admin >= $user->role->admin) {

            switch ($action) {
                case 'password':
                    $data = [];
                    $data['user'] = $user;
                    $data['level'] = 'admin';
                    $data['form'] = View::make('admin::acl.users.forms.password', array('current_password' => ($authUser->id == $userId), 'userId' => $user->id,
                        'can_change_pass' => Auth::action('users.password')));
                    $data['success'] = $user->change_password();
                    AdminLog::new_log('User \'' . $user->email . '\' updated, password changed');
                    $this->layoutData['content'] = View::make('admin::commons.account.password', $data);
                    break;
                case 'status':
                    // stop admins disabling super admins
                    if ($authUser->id != $user->id) {
                        $v = Validator::make(Request::all(), array(
                                'set' => 'integer|min:0|max:1'
                            )
                        );
                        if ($v->passes()) {
                            $user->active = Request::input('set');
                            $user->save();
                            AdminLog::new_log('User \'' . $user->email . '\' updated, status changed');
                            return 1;
                        }
                    }
                    return 0;
                    break;
                default:
                    $v = Validator::make(Request::all(), array(
                            'name' => 'required|min:3',
                            'role' => 'required|integer',
                            'email' => 'required|email',
                            'language' => 'required|integer',
                            'brands' => 'required|array',
                            'countries' => 'required|array'
                        )
                    );
                    $attrNamesTrans = array(
                        'name' => trans('admin::userTranslations.form_edit.user_name'),
                        'role' => trans('admin::userTranslations.form_edit.user_role'),
                        'email' => trans('admin::userTranslations.form_edit.user_email'),
                        'language' => trans('admin::userTranslations.form_edit.language'),
                        'brands' => trans('admin::userTranslations.form_edit.brands'),
                        'countries' => trans('admin::userTranslations.form_edit.countries')
                    );
                    $v->setAttributeNames($attrNamesTrans);

                    if ($v->passes()) {
                        $saved_bd = false;
                        try {
                            DB::beginTransaction();
                            //$password = str_random(8);
                            $user_edit = $user;
                            $user_edit->id = $user->id;
                            $user_edit->name = Request::input('name');
                            $user_edit->email = Request::input('email');
                            $user_edit->position = !is_null(Request::input('position')) ? Request::input('position') : '';
                            $user_edit->role_id = Request::input('role');
                            $user_edit->language_id = Request::input('language');
                            $user_edit->save();

                            $saveBrands = array();
                            foreach (Request::input('brands') as $brand_id) {
                                $saveBrands[] = array('user_id' => $user_edit->id, 'brand_id' => $brand_id);
                            }

                            $user_edit->userBrands()->delete();
                            $user_edit->userBrands()->createMany($saveBrands);

                            $saveCountries = array();
                            foreach (Request::input('countries') as $country_id) {
                                $saveCountries[] = array('user_id' => $user_edit->id, 'country_id' => $country_id);
                            }
                            $user_edit->userCountries()->delete();
                            $user_edit->userCountries()->createMany($saveCountries);

                            DB::commit();
                            $saved_bd = true;
                        } catch (\Exception $ex) {

                            DB::rollback();
                            $error_save_bd = trans('admin::userTranslations.form_edit.msg_error_bd:'.$ex->getMessage());
                        }

                        if (!$saved_bd) {
                            $this->layoutData['content'] = View::make('admin::acl.users.edit', array('success' => false, 'user' => $user, 'email_message' => '', 'email_status' => '', 'error_save_bd' => $error_save_bd,
                                'can_edit' => Auth::action('users.edit'), 'can_change_pass' => Auth::action('users.password')));
                        } else {
                            AdminLog::new_log('User \'' . $user->email . '\' updated, updated data');

                            if (Request::input('send_email') == 1) {

                                $failures = Mail::failures();

                                if (empty($failures)) {
                                    $email_message = trans('admin::userTranslations.form_edit.msg_email_sent');
                                    $email_status = 'success';
                                } else {
                                    $email_message = trans('admin::userTranslations.form_edit.msg_error_email_sent');
                                    $email_status = 'warning';
                                }
                            } else {
                                $email_message = '';
                                $email_status = '';
                            }

                            $this->layoutData['content'] = View::make('admin::acl.users.edit', array('success' => true, 'user' => $user, 'email_message' => $email_message,
                                'email_status' => $email_status, 'error_save_bd' => '', 'can_edit' => Auth::action('users.edit'), 'can_change_pass' => Auth::action('users.password')));
                        }
                    } else {
                        FormMessage::set($v->messages());
                        $this->getEdit($userId);
                    }
            }

            /* Codigo original para editar datos de usuario y password
            switch ($action) {
                case 'password':
                    $data = [];
                    $data['user'] = $user;
                    $data['level'] = 'admin';
                    $data['form'] = View::make('admin::acl.users.forms.password', array('current_password' => ($authUser->id == $userId)));
                    $data['success'] = $user->change_password();
                    AdminLog::new_log('User \'' . $user->email . '\' updated, password changed');
                    $this->layoutData['content'] = View::make('admin::commons.account.password', $data);
                    break;
                case 'name':
                    $user->name = Request::input('name');
                    $user->save();
                    return  redirect()->route('admin.users.edit', ['userId' => $userId]);
                    break;
                case 'role':
                    $user_role = UserRole::find(Request::input('role'));
                    if (!empty($user_role) && $user_role->admin <= $authUser->role->admin) {
                        $user->role_id = Request::input('role');
                        AdminLog::new_log('User \'' . $user->email . '\' updated, role change');
                        $user->save();
                        $this->layoutData['content'] = View::make('admin::acl.users.role', array('user' => $user, 'success' => true));
                    } else {
                        $this->getEdit($userId, $action);
                    }
                    break;
                case 'status':
                    // stop admins disabling super admins
                    if ($authUser->id != $user->id) {
                        $v = Validator::make(Request::all(), array(
                                'set' => 'integer|min:0|max:1'
                            )
                        );
                        if ($v->passes()) {
                            $user->active = Request::input('set');
                            $user->save();
                            AdminLog::new_log('User \'' . $user->email . '\' updated, status changed');
                            return 1;
                        }
                    }
                    return 0;
                    break;
            }*/
        } else {
            return trans('admin::userTranslations.form_edit.msg_cant_edit');
        }
        return null;

    }

    public function getEdit($userId = 0, $action = null)
    {

        $user = User::find($userId);
        $authUser = Auth::user();
        //dd($authUser);
        if (!empty($user)) {
            switch ($action) {
                case 'password':
                    $data = [];
                    $data['user'] = $user;
                    $data['level'] = 'admin';
                    $data['form'] = View::make('admin::acl.users.forms.password', array('current_password' => ($authUser->id == $userId), 'userId' => $user->id,
                        'can_change_pass' => Auth::action('users.password')));
                    $this->layoutData['content'] = View::make('admin::commons.account.password', $data);
                    break;

                default:
                    $userBrands = User::find($userId)->userBrands;
                    $userCountries = User::find($userId)->userCountries;
                    $details = View::make('admin::acl.users.info', array('user' => $user));

                    $all_roles = UserRole::where('admin', '<=', $authUser->role->admin)->get();
                    $roles = array();

                    foreach ($all_roles as $role) {
                        if ($authUser->role_id == 1 || $role->id != 1) {
                            $roles[$role->id] = $role->name;
                        }
                    }

                    $idsUserBrands = array_pluck($userBrands, 'brand_id');
                    $countriesBrand = BrandCountry::whereIn('brand_id', $idsUserBrands)->where('active', '=', 1)->get();
                    $countries = [];
                    if(!empty($countriesBrand)){
                        foreach ($countriesBrand as $cb) {
                                $countries[$cb->country->id] = $cb->country->name;
                        }
                    }
                    $brands = Brand::selectArray();
                    //$countries = Country::selectArray();
                    $languages = Language::selectArray();

                    /*if ($authUser->role->admin >= $user->role->admin) {
                        $can_edit = true;
                    } else {
                        $can_edit = false;
                    }*/
                    $this->layoutData['content'] = View::make('admin::acl.users.edit', array('user' => $user, 'account' => $details, 'can_edit' => Auth::action('users.edit'),
                        'can_change_pass' => Auth::action('users.password'), 'roles' => $roles, 'languages' => $languages, 'countries' => $countries, 'brands' => $brands,
                        'userBrands' => $userBrands, 'userCountries' => $userCountries));
            }
        } else {
            $this->layoutData['content'] = trans('admin::userTranslations.form_edit.msg_user_not_found');
        }
        /*
        if (!empty($user)) {
            switch ($action) {
                case 'password':
                    $data = [];
                    $data['user'] = $user;
                    $data['level'] = 'admin';
                    $data['form'] = View::make('admin::acl.users.forms.password', array('current_password' => ($authUser->id == $userId)));
                    $this->layoutData['content'] = View::make('admin::commons.account.password', $data);
                    break;
                case 'name':
                    $data = [];
                    $data['user'] = $user;
                    $data['level'] = 'admin';
                    $data['form'] = View::make('admin::acl.users.forms.name', array('user' => $user));
                    $this->layoutData['content'] = View::make('admin::commons.account.name', $data);
                    break;
                case 'role':
                    $all_roles = UserRole::where('admin', '<=', $authUser->role->admin)->get();
                    $roles = array();
                    foreach ($all_roles as $role) {
                        $roles[$role->id] = $role->name;
                    }
                    $this->layoutData['content'] = View::make('admin::acl.users.role', array('user' => $user, 'roles' => $roles));
                    break;
                default:
                    $details = View::make('admin::acl.users.info', array('user' => $user));

                    if ($authUser->role->admin >= $user->role->admin) {
                        $can_edit = true;
                    } else {
                        $can_edit = false;
                    }
                    $this->layoutData['content'] = View::make('admin::acl.users.edit', array('user' => $user, 'account' => $details, 'can_edit' => $can_edit));
            }
        } else {
            $this->layoutData['content'] = 'User not found';
        }*/

    }

    public function getAdd()
    {
        $authUser = Auth::user();
        $all_roles = UserRole::where('admin', '<=', $authUser->role->admin)->get();
        $roles = array();
        foreach ($all_roles as $role) {
            if($role->id != 1){
                $roles[$role->id] = $role->name;
            }
        }


        $brands = Brand::selectArrayActive();
        //$countries = Country::selectArrayActive();
        $countries = [];
        if(Request::has('brands'))
        {
            $countriesBrand = BrandCountry::whereIn('brand_id', Request::get('brands'))->where('active', '=', 1)->get();
            if(!empty($countriesBrand)){
                foreach ($countriesBrand as $cb) {
                    $countries[$cb->country->id] = $cb->country->name;
                }
            }
        }
        //dd($countries, Request::all());

        $languages = Language::selectArrayActive();

        $this->layoutData['content'] = View::make('admin::acl.users.add', array('roles' => $roles, 'languages' => $languages,
            'countries' => $countries, 'brands' => $brands, 'can_add' => Auth::action('users.add')));
    }

    public function postAdd()
    {
        //dd(Request::all());
        $authUser = Auth::user();
        //Form validations whit translates
        $v = Validator::make(Request::all(), array(
                'name' => 'required|min:3',
                'role' => 'required|integer',
                'email' => 'required|email',
                'language' => 'required|integer',
                'brands' => 'required|array',
                'countries' => 'required|array',
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required',
            )
        );
        $attrNamesTrans = array(
            'name' => trans('admin::userTranslations.form_add.user_name'),
            'role' => trans('admin::userTranslations.form_add.user_role'),
            'email' => trans('admin::userTranslations.form_add.user_email'),
            'language' => trans('admin::userTranslations.form_add.language'),
            'brands' => trans('admin::userTranslations.form_add.brands'),
            'countries' => trans('admin::userTranslations.form_add.countries'),
            'password' => trans('admin::userTranslations.form_add.int_password'),
            'password_confirmation' => trans('admin::userTranslations.form_add.confirm_int_password'),
        );
        $v->setAttributeNames($attrNamesTrans);

        $perm_issue = true;
        $role = UserRole::find(Request::input('role'));
        if (!empty($role) && $role->admin <= $authUser->role->admin) {
            $perm_issue = false;
        }

        if ($v->passes() && !$perm_issue) {
            $saved_bd = false;
            try {
                DB::beginTransaction();
                //$password = str_random(8);
                $new_user = new User;
                $new_user->name = Request::input('name');
                $new_user->email = Request::input('email');
                $new_user->position = !is_null(Request::input('position')) ? Request::input('position') : '';
                $new_user->role_id = Request::input('role');
                $new_user->language_id = Request::input('language');
                $new_user->password = Hash::make(Request::input('password'));
                $new_user->save();

                $saveBrands = array();
                foreach (Request::input('brands') as $brand_id) {
                    $saveBrands[] = array('user_id' => $new_user->id, 'brand_id' => $brand_id);
                }
                $new_user->userBrands()->createMany($saveBrands);

                $saveCountries = array();
                foreach (Request::input('countries') as $country_id) {
                    $saveCountries[] = array('user_id' => $new_user->id, 'country_id' => $country_id);
                }
                $new_user->userCountries()->createMany($saveCountries);

                DB::commit();
                $saved_bd = true;
            } catch (\Exception $ex){

                DB::rollback();
                $error_save_bd =  trans('admin::userTranslations.form_add.msg_error_bd');
            }

            if (!$saved_bd) {
                $this->layoutData['content'] = View::make('admin::acl.users.add', array('success' => false, 'password' => Request::input('password'), 'email_message' => '', 'email_status' => '',
                    'error_save_bd' => $error_save_bd, 'can_add' => Auth::action('users.add')));
            } else {
                AdminLog::new_log('User \'' . $new_user->email . '\' added');

                if (Request::input('send_email') == 1) {

                    $new_user->sendNewAccountNotification(Request::input('password'));

                    $failures = Mail::failures();

                    if (empty($failures)) {
                        $email_message = trans('admin::userTranslations.form_add.msg_email_sent');
                        $email_status = 'success';
                    } else {
                        $email_message = trans('admin::userTranslations.form_add.msg_error_email_sent');
                        $email_status = 'warning';
                    }
                } else {
                    $email_message = '';
                    $email_status = '';
                }

                $this->layoutData['content'] = View::make('admin::acl.users.add', array('success' => true, 'password' => Request::input('password'), 'email_message' => $email_message,
                    'email_status' => $email_status, 'error_save_bd' => '', 'can_add' => Auth::action('users.add')));
            }
        } else {
            FormMessage::set($v->messages());
            if ($perm_issue) {
                FormMessage::add('role', trans('admin::userTranslations.form_add.msg_no_permission_create'));
            }
            $this->getAdd();
        }
    }

    public function postDelete($userId = 0)
    {
        $error = 'User with ID '.$userId.' not found';
        if ($user = User::find($userId)) {
            if (Auth::user()->role->admin >= $user->role->admin && Auth::user()->id != $user->id) {
                return json_encode($user->delete());
            }
            $error = 'Can\'t remove super admin or your own account';
        }
        return Response::make($error, 500);
    }


    public function postChangeSelectBrandFilter(){
        $select = Request::get('brands');
        $countries = [];
        if(!empty($select)){
            $countriesBrand = BrandCountry::whereIn('brand_id', $select)->where('active', '=', 1)->get();
            $countries = [];
            if(!empty($countriesBrand)){
                foreach ($countriesBrand as $cb) {
                    $countries[$cb->country->id] = $cb->country->name;
                }
            }
        }
        return json_encode($countries);
    }

    public function remove(Request $request, User $user) {
        $user->active = 0;
        $user->delete = 1;
        $user->update();

        return redirect()->route('admin.users.index');
    }
}
