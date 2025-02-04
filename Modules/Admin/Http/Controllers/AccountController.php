<?php namespace Modules\Admin\Http\Controllers;

use Auth;;
use Modules\CMS\Libraries\Builder\FormMessage;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\Admin\Entities\Language;
use Modules\Admin\Entities\ACL\User;
use Mail;
use Request;
use Validator;
use View;

class AccountController extends Controller
{

    private function _change_password_checks($code)
    {
        $this->layoutData['title'] = 'Forgotten Password';
        try {
            return User::findFromTmpCode($code);
        } catch (\Exception $e) {
            $this->layoutData['content'] = $e->getMessage();
        }
        return null;
    }

    public function changePassword($code = null)
    {
        $user = $this->_change_password_checks($code);             
        if (!empty($user)) {
            $view_data = array(
                'user' => $user,
                'level' => 'guest',
                'form' => View::make('admin::acl.users.forms.password', array('current_password' => false,
                    'can_change_pass'=>true))
            );
            if (!empty($_POST)) {
                if ($user->change_password($code)) {
                    $view_data['success'] = true;
                }
            }
            $this->layoutData['content'] = View::make('admin::commons.account.password', $view_data);
        }
    }

    public function forgottenPassword()
    {
        $view_data = array();
        $rules = array(
            'email' => 'required|email',
        );
        $validation = Validator::make(Request::all(), $rules);

        if ($_POST && $validation->fails()) {
            FormMessage::set($validation->messages());
        } elseif ($_POST) {
            $email_addr = Request::input('email');
            $user = User::where('email', '=', $email_addr)->first();

            if ($user !== null) {
                if (!Auth::action('account.password', ['user_id' => $user->id])) {
                    FormMessage::add('email', 'You can\'t change the password for this account');
                } else {

                    $user->sendPasswordResetNotification();

                    $failures = Mail::failures();

                    if (empty($failures)) {
                        $view_data['success'] = 'We have sent an email to you with a link to change your password.';
                    } else {
                        FormMessage::add('email', 'There was an error sending mail, please contact <a href="mailto:support@web-feet.co.uk?Subject=' . config('cms.site.name') . ': Forgotten Password">support</a>.');
                    }
                }
            } else {
                FormMessage::add('email', 'We couldn\'t find your records.');
            }
        }
        $this->layoutData['title'] = 'Forgotten Password';
        $this->layoutData['content'] = View::make('admin::commons.forgotten_password', $view_data);
    }

    public function postPassword()
    {
        if (!Auth::user()->change_password()) {
            $this->getPassword();
        } else {
            $data = [];
            $data['user'] = Auth::user();
            $data['level'] = 'user';
            $data['success'] = true;
            $this->layoutData['content'] = View::make('admin::commons.account.password', $data);
        }
    }

    public function getPassword()
    {
        $data = [];
        $data['user'] = Auth::user();
        $data['level'] = 'user';
        $data['form'] = View::make('admin::acl.users.forms.password', array('current_password' => true, 'can_change_pass' => Auth::action('account.password') ));
        $this->layoutData['content'] = View::make('admin::commons.account.password', $data);
    }

    private function _existing_blog_login()
    {
        $authLogin = Auth::user();
        $post = Request::input('blog_login');
        if (!empty($post)) {
            return $post;
        } elseif ($authLogin->blog_login) {
            $blog_login = unserialize($authLogin->blog_login);
            return $blog_login['login'];
        } else {
            return '';
        }
    }

    public function postBlog()
    {
        $rules = array(
            'blog_login' => 'required',
            'blog_password' => 'required'
        );
        $validation = Validator::make(Request::all(), $rules);
        $data = [];
        $data['form'] = View::make('admin::acl.users.forms.blog', array('blog_login' => $this->_existing_blog_login()));
        if ($validation->fails()) {
            $this->layoutData['content'] = View::make('admin::commons.account.blog', $data);
        } else {
            $authLogin = Auth::user();
            $authLogin->blog_login = serialize(['login' => Request::input('blog_login'), 'password' => Request::input('blog_password')]);
            $authLogin->save();
            $data['success'] = true;
            $this->layoutData['content'] = View::make('admin::commons.account.blog', $data);
        }
    }

    public function postPageState()
    {
        $postData = Request::all();
        $pageStates = Auth::user()->getPageStates();

        if ($postData['expanded'] == "false" && ($key = array_search($postData['page_id'], $pageStates)) !== false) {
            unset($pageStates[$key]);
            Auth::user()->savePageStates($pageStates);
            return 1;
        } elseif ($postData['expanded'] == "true" && !in_array($postData['page_id'], $pageStates)) {
            $pageStates[] = $postData['page_id'];
            Auth::user()->savePageStates($pageStates);
            return 1;
        }

        return 0;
    }

    public function getLanguage()
    {
        $this->layoutData['content'] = View::make('admin::commons.account.language', ['language' => \Modules\Admin\Entities\Language::current(), 'languages' => Language::selectArray(), 'saved' => false]);
    }

    public function postLanguage()
    {
        $input = Request::get('language');
        Language::set($input);

        return \redirect()->route('admin.account.language');
    }

    public function getBlog()
    {
        $form = View::make('admin::acl.users.forms.blog', array('blog_login' => $this->_existing_blog_login()));
        $this->layoutData['content'] = View::make('admin::commons.account.blog', array('form' => $form));
    }

    public function getIndex()
    {
        $user = Auth::user();
        if(Auth::action('account.editNamePassword')) {
            $account = View::make('admin::acl.users.info', array('user' => $user));
            $this->layoutData['content'] = View::make('admin::commons.account', array('account' => $account, 'auto_blog_login' => (!empty(config('cms.blog.url') && Auth::action('account.blog'))),
                'setAlias' => Auth::action('account.name'), 'change_password' => Auth::action('account.password'),
                'userId' => $user->id));
        } elseif (Auth::action('users.edit')) {
            return  redirect()->route('admin.users.edit', ['userId' => $user->id]);
        }


    }

    public function getName()
    {
        $form = View::make('admin::acl.users.forms.name', array('user' => Auth::user()));
        $this->layoutData['content'] = View::make('admin::commons.account.name', array('form' => $form));
    }

    public function postName()
    {
        $user = Auth::user();
        $user->name = Request::input('name');
        $user->save();
        return \redirect()->route('admin.account.index');
    }


    public function testSession(){
        //session()->flush();
        return \Session::all();

    }

}
