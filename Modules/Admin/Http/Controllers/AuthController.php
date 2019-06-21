<?php namespace Modules\Admin\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Session;
use Modules\Admin\Entities\Language;
use Modules\CMS\Libraries\Builder\FormMessage;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Cookie;
use Request;
use View;

class AuthController extends Controller
{

    public function login()
    {
        if (Request::input()) {
            $userData = [
                'username' => Request::input('username'),
                'password' => Request::input('password'),
                'active' => 1
            ];
            $rememberMe = Request::input('remember') == 'yes';

            if ($e = Auth::attempt($userData, $rememberMe)) {
                Language::set(Auth::user()->language_id);

                return \redirect()->route('admin.home.index');
            } else {
                FormMessage::add('username', 'Username or password incorrect');
                FormMessage::add('password', ' ');
            }
        }

        $this->layoutData['content'] = View::make('admin::acl.login');
        $this->layoutData['title'] = 'Login';
        return null;
    }

    public function logout()
    {
        Auth::logout();
        return \redirect()->route('admin.login');
    }

}
