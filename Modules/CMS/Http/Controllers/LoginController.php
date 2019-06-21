<?php

namespace Modules\CMS\Http\Controllers;

use App\Helpers\RestWrapper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Modules\Shopping\Entities\Blacklist;

class LoginController extends Controller
{
    public function getLogin(Request $request)
    {
        if ($request->eo && config('settings::frontend.webservices') == 1)
        {
            $decryptUser = Crypt::decryptString($request->input('eo'));

            if ($decryptUser != null || $decryptUser != '')
            {
                $decryptUser = explode(' ', $decryptUser);

                //Verificamos si el usuario esta en blacklist
                $blackList = Blacklist::where('eo_number', $decryptUser[2])->where('active', 1)->where('delete', 0)->first();

                if ($blackList)
                    return redirect('/');

                $resultRest = $this->loginEo(array(
                    'country_corbiz'    => $decryptUser[0],
                    'language_corbiz'   => $decryptUser[1],
                    'code'              => $decryptUser[2],
                    'password'          => $decryptUser[3],
                    'url_previous'      => '/',
                ));

                if ($resultRest['success'] == true)
                {
                    if (Session::has('portal.register_customer'))
                    {
                        Session::forget('portal.register_customer');
                        Session::forget('portal.request_businessman');
                    }

                    if (Session::has('portal.register'))
                    {
                        Session::forget('portal.register');
                        Session::forget('portal.request_businessman');
                    }

                    return redirect($resultRest['message']);
                }
            }
        }
        else
        {
            return redirect('/');
        }
    }

    public function postAuth(Request $request)
    {
        if ($request->ajax())
        {
            $rules = [
                'code'      => 'required',
                'password'  => 'required',
            ];

            $messages = [
                'code.required'     => trans('cms::login_aside.fields.required'),
                'password.required' => trans('cms::login_aside.fields.required'),
            ];

            $labels = [
                'code'      => trans('cms::login_aside.section.content.placeholder.code'),
                'password'  => trans('cms::login_aside.section.content.placeholder.password'),
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $labels);

            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            //Verificamos si el usuario esta en blacklist
            $blackList = Blacklist::where('eo_number', $request->code)->where('active', 1)->where('delete', 0)->first();

            if ($blackList)
            {
                return response()->json([
                    'success'   => false,
                    'message'   => [
                        'error_ws'  => trans('cms::login_aside.blacklist_message_text'),
                    ],
                ]);
            }

            //Verificamos los datos de acceso en la API Rest
            $resultRest = $this->loginEo($request);

            if ($resultRest['success'] == true)
            {
                if (Session::has('portal.register_customer'))
                {
                    Session::forget('portal.register_customer');
                    Session::forget('portal.request_businessman');
                }

                if (Session::has('portal.register'))
                {
                    Session::forget('portal.register');
                    Session::forget('portal.request_businessman');
                }

                return response()->json([
                    'success'   => $resultRest['success'],
                    'message'   => $resultRest['message'],
                ]);
            }
            else
            {
                return response()->json([
                    'success'   => $resultRest['success'],
                    'message'   => [
                        'error_ws'  => $resultRest['message'],
                    ],
                ]);
            }
        }
    }

    public function loginEo($data)
    {
        $urlRest        = session('portal.main.webservice');
        $restWrapper    = new RestWrapper($urlRest."validateLogin");
        $params         = [
            'request' => [
                'EntrepreneurParams' => [
                    'ttEntrepreneurParams' => [
                        [
                            'CountryKey'    => $data['country_corbiz'],
                            'Lang'          => $data['language_corbiz'],
                            'DistId'        => $data['code'],
                            'Password'      => $data['password'],
                        ]
                    ]
                ]
            ]
        ];

        $result = $restWrapper->call('POST', $params, 'json', ['http_errors' => false]);

        if ($result['success'] == true && isset($result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]))
        {
            //Creamos la variable eo en sesion con los valores obtenidos de $resultLogin
            session()->put('portal.eo.auth', true);
            session()->put('portal.eo.distId', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['distId']);
            session()->put('portal.eo.name1', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['name1']);
            session()->put('portal.eo.name2', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['name2']);
            session()->put('portal.eo.country', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['country']);
            session()->put('portal.eo.phone', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['phone']);
            session()->put('portal.eo.celphone', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['celphone']);
            session()->put('portal.eo.email', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['email']);
            session()->put('portal.eo.documentKey', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['documenKey']);
            session()->put('portal.eo.documentNum', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['documentNum']);
            session()->put('portal.eo.carrerTitle', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['carrerTitle']);
            session()->put('portal.eo.shortTitleName', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['shortTitleName']);
            session()->put('portal.eo.longTitleName', $result['responseWS']['response']['LoginData']['dsLoginData']['ttLoginData'][0]['longTitleName']);

            if ($data['url_previous'] != null || $data['url_previous'] != '') {
                return [
                    'success' => true,
                    'message' => $data['url_previous']
                ];
            }
            else {
                return [
                    'success' => true,
                    'message' => url()->previous(),
                ];
            }
        }
        else if ($result['success'] == false && isset($result['responseWS']['response']['Error']['dsError']['ttError'][0]))
        {
            return [
                'success'   => false,
                'message'   => $result['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser'],
            ];
        }
        else
        {
            return [
                'success'   => false,
                'message'   => trans('cms::reset_password.error_rest'),
            ];
        }
    }

    /* * * Login - Cerrar Sesión * * */
    public function getLogout()
    {
        /* Eliminamos la Variable de Sesión eo */
        Session::forget('portal.eo');

        /* Obtenemos el Prefijo de la URL para Redirigir a Home */
        $prefix = Config::get('cms.prefix_logout');

        foreach ($prefix as $p)
        {
            $url_previous = url()->previous();
            $url_prefix = explode('/', $url_previous);

            /* Redirigir a Home */
            if (Route::current()->getPrefix() == $p || $url_prefix[3] == $p)
            {
                return response()->json([
                    'success'   => true,
                    'message'   => url('/'),
                ]);
            }
            /* Redirigir a la URL Previa */
            else
            {
                return response()->json([
                    'success'   => true,
                    'message'   => url()->previous(),
                ]);
            }
        }
    }
}