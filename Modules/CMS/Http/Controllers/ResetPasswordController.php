<?php

namespace Modules\CMS\Http\Controllers;

use App\Helpers\CommonMethods;
use App\Helpers\RestWrapper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Entities\Country;
use Modules\CMS\Helpers\CodeReset;
use Modules\Shopping\Entities\SecurityQuestionsCountry;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        $this->CommonMethods = new CommonMethods();
    }

    /* * * Reset Password - Step 1 * * */
    public function index(Request $request)
    {
        /* Obtenemos mail de contacto en base al país */
        $emailsContacts = Config::get('cms.email_contact');
        $emailContact   = $emailsContacts[Session::get('portal.main.country_corbiz')];

        /* Vista Step 1 */
        return view('cms::frontend.reset.step1', [
            'brand'         => Session::get('portal.main.brand.name'),
            'emailContact'  => $emailContact,
        ]);
    }

    /* * * Reset Password - Validar Usuario * * */
    public function postValidateDist(Request $request)
    {
        if ($request->ajax())
        {
            /* Validación de Campos */
            $rules = [
                'dist_num'  => 'required',
            ];

            $messages = [
                'dist_num.required' => trans('cms::reset_password.fields.required'),
            ];

            $labels = [
                'dist_num'  => trans('cms::reset_password.step1.placeholder'),
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $labels);

            /* Si no cumplen con las reglas se envian los mensajes de error */
            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            /* Servicio getDataPassword para obtener información del usuario */
            $urlRest        = Session::get('portal.main.webservice');
            $restWrapper    = new RestWrapper($urlRest.'getDataPassword?CountryKey=' . $request->country_corbiz . '&Lang=' . $request->language_corbiz . '&DistId=' . $request->dist_num);
            $resultRest     = $restWrapper->call('GET', [],'json', ['http_errors' => false]);

            /* Validamos si el acceso al Servicio fue correcto y si la respuesta no viene vacia */
            if ($resultRest['success'] == true && isset($resultRest['responseWS']['response']['DataPassword']['dsDataPassword']['ttDataPassword'][0]))
            {
                /* Ocultamos el mail Ej.: d*****@test.com */
                $email  = explode('@', $resultRest['responseWS']['response']['DataPassword']['dsDataPassword']['ttDataPassword'][0]['email']);
                $email  = substr($email[0], 0, min(1, strlen($email[0])-1)) . str_repeat('*', max(1, 5)) . '@' . $email[1];

                /* Creamos la variable de sesion eo_reset en el cual se alamcena la información obtenida del Servicio */
                Session::put('portal.eo_reset.distId', $resultRest['responseWS']['response']['DataPassword']['dsDataPassword']['ttDataPassword'][0]['distId']);
                Session::put('portal.eo_reset.distName', $resultRest['responseWS']['response']['DataPassword']['dsDataPassword']['ttDataPassword'][0]['distName']);
                Session::put('portal.eo_reset.email', $resultRest['responseWS']['response']['DataPassword']['dsDataPassword']['ttDataPassword'][0]['email']);
                Session::put('portal.eo_reset.email2', $email);
                Session::put('portal.eo_reset.bornDate', $resultRest['responseWS']['response']['DataPassword']['dsDataPassword']['ttDataPassword'][0]['bornDate']);
                Session::put('portal.eo_reset.distQuestion', $resultRest['responseWS']['response']['DataPassword']['dsDataPassword']['ttDataPassword'][0]['distQuestion']);
                Session::put('portal.eo_reset.distAnswer', $resultRest['responseWS']['response']['DataPassword']['dsDataPassword']['ttDataPassword'][0]['distAnswer']);
                Session::put('portal.eo_reset.country', $resultRest['responseWS']['response']['DataPassword']['dsDataPassword']['ttDataPassword'][0]['country']);

                /* Redirección al siguiente paso */
                return response()->json([
                    'success'   => true,
                    'message'   => route('resetpassword.option'),
                ]);
            }
            /* Validamos si el acceso al Servicio fue incorrecto y si la respuesta de error no viene vacia */
            else if ($resultRest['success'] == false && isset($resultRest['responseWS']['response']['Error']['dsError']['ttError'][0]))
            {
                /* Se envía el mensaje de error del Servicio */
                return response()->json([
                    'success'   => 'errors_corbiz',
                    'message'   => $resultRest['responseWS']['response']['Error']['dsError']['ttError'],
                ]);
            }
            /* Si el Servicio no esta funcionando */
            else
            {
                /* Se envia mensaje de falla de Servicio */
                return response()->json([
                    'success'   => 'errors_corbiz',
                    'message'   => [
                        0   => [
                            'messUser'  => trans('cms::reset_password.error_rest'),
                        ],
                    ],
                ]);
            }
        }
    }

    /* * * Reset Password - Step 2 * * */
    public function getOption()
    {
        /* Vista Step 2 */
        return view('cms::frontend.reset.step2', [
            'brand' => Session::get('portal.main.brand.name'),
        ]);
    }

    /* * * Reset Password - Validar Opción * * */
    public function postOption(Request $request)
    {
        if ($request->ajax())
        {
            /* Validación de Campos */
            $rules = [
                'option_method' => 'required|in:1,0',
            ];

            $messages = [
                'option_method.required'    => trans('cms::reset_password.fields.required'),
                'option_method.in'          => trans('cms::reset_password.fields.in'),
            ];

            $labels = [
                'option_method' => trans('cms::reset_password.step2.subtitle'),
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $labels);

            /* Si no cumplen con las reglas se envian los mensajes de error */
            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            /* Guardamos la opción seleccionado en la session eo_reset.option */
            Session::put('portal.eo_reset.option', $request->option_method);

            /* Si el metodo es 1 se realizan las siguientes acciones */
            if ($request->option_method == 1)
            {
                /* Generamos código de verificación */
                $codeReset = new CodeReset();

                $code = $codeReset->getCodeReset([
                    'distId'    => Session::get('portal.eo_reset.distId'),
                    'length'    => 8,
                ]);

                /* Guardamos el código en la sesión eo_reset.code */
                Session::put('portal.eo_reset.code', $code);

                /* Obtenemos la información del usuario almacenada en la sesión */
                $distributor = Session::get('portal.eo_reset');

                /* Obtenemos el mail en base al país para el envío del código */
                $emailsSend = Config::get('cms.email_send');
                $emailSend  = $emailsSend[Session::get('portal.eo_reset.country')];

                /* Realizamos el envío del mail al usuario */
                Mail::send('cms::frontend.reset.restore', ['distributor' => $distributor], function ($m) use ($distributor, $emailSend) {
                    $m->from($emailSend, trans('cms::reset_password.email.title'));
                    $m->to('daniel.herrera@omnilife.com'/*$distributor['email']*/, $distributor['distName'])->subject(trans('cms::reset_password.email.subject'));
                });

                /* Redireccionamos al siguiente paso para la validación del código enviado */
                return response()->json([
                    'success'   => true,
                    'message'   => route('resetpassword.code'),
                ]);
            }
            /* Si la opción es 0 se redirige al siguiente paso para la validación de la fecha de nacimiento */
            else
            {
                return response()->json([
                    'success'   => true,
                    'message'   => route('resetpassword.borndate'),
                ]);
            }
        }
    }

    /* * * Reset Password - Regresar a Step 1 * * */
    public function getBack()
    {
        /* Eliminamos la variable eo_reset de la sesión */
        Session::forget('portal.eo_reset');

        /* Redirigimos a la Vista de Step 1 */
        return response()->json([
            'success'   => true,
            'message'   => route('resetpassword.index'),
        ]);
    }

    /* * * Reset Password - Step 3.1 * * */
    public function getVerificationCode()
    {
        /* Vista Step 3.1 */
        return view('cms::frontend.reset.step3_1', [
            'brand' => Session::get('portal.main.brand.name'),
        ]);
    }

    /* * * Reset Password - Validar Código * * */
    public function postVerificationCode(Request $request)
    {
        if ($request->ajax())
        {
            /* Validación de Campos */
            $rules = [
                'verification_code' => 'required|min:8|max:8',
            ];

            $messages = [
                'verification_code.required'    => trans('cms::reset_password.fields.required'),
                'verification_code.min'         => trans('cms::reset_password.fields.min'),
                'verification_code.max'         => trans('cms::reset_password.fields.max'),
            ];

            $labels = [
                'verification_code' => trans('cms::reset_password.step3_1.code')
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $labels);

            /* Si no cumplen con las reglas se envian los mensajes de error */
            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            /* Validamos si el código es correcto */
            if ($request->verification_code != Session::get('portal.eo_reset.code'))
            {
                /* Enviamos mensaje de error */
                return response()->json([
                    'success'   => 'errors_corbiz',
                    'message'   => [
                        0   => [
                            'messUser'  => trans('cms::reset_password.step3_1.code_error'),
                        ],
                    ],
                ]);
            }

            /* Redirigimos al Step 5 */
            return response()->json([
                'success'   => true,
                'message'   => route('resetpassword.new_password'),
            ]);
        }
    }

    /* * * Reset Password - Regresar a Step 2 * * */
    public function getBackCode()
    {
        /* Eliminamos el Código de Verificación de la sesión */
        Session::forget('portal.eo_reset.code');

        /* Redirigimos a la Vista de Step 2 */
        return response()->json([
            'success'   => true,
            'message'   => route('resetpassword.option')
        ]);
    }

    /* * * Reset Password - Step 3.2 * * */
    public function getBornDate()
    {
        /* Obtenemos el ID del País*/
        $country = Country::where('corbiz_key', Session::get('portal.eo_reset.country'))->first();

        /* Obtenemos los Meses */
        $months = Config::get('shopping.months');

        /* Vista Step 3.2 */
        return view('cms::frontend.reset.step3_2', [
            'brand'     => Session::get('portal.main.brand.name'),
            'country'   => $country->id,
            'months'    => $months,
        ]);
    }

    /* * * Reset Password - Validar Born Date * * */
    public function postBornDate(Request $request)
    {
        if ($request->ajax())
        {
            /* Validación de Campos */
            $rules = [
                'day'   => 'required',
                'month' => 'required',
                'year'  => 'required',
            ];

            $messages = [
                'day.required'      => trans('cms::reset_password.fields.required'),
                'month.required'    => trans('cms::reset_password.fields.required'),
                'year.required'     => trans('cms::reset_password.fields.required'),
            ];

            $labels = [
                'day'   => trans('cms::reset_password.step3.day'),
                'month' => trans('cms::reset_password.step3.month'),
                'year'  => trans('cms::reset_password.step3.year'),
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $labels);

            /* Si no cumplen con las reglas se envian los mensajes de error */
            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            $bornDateRest = Session::get('portal.eo_reset.bornDate');
            $bornDateRequest = $request->year . '-' . $request->month . '-' . $request->day;

            /* Validamos si la fecha de nacimiento es correcta */
            if ($bornDateRequest != trim($bornDateRest))
            {
                /* Enviamos Mensaje de Error*/
                return response()->json([
                    'success'   => 'errors_corbiz',
                    'message'   => [
                        0   => [
                            'messUser'  => trans('cms::reset_password.step3.error_borndate'),
                        ],
                    ],
                ]);
            }

            /* Redirigir a Step 4 */
            return response()->json([
                'success'   => true,
                'message'   => route('resetpassword.question'),
            ]);
        }
    }

    /* * * Reset Password - Obtener Parametros de Años por País * * */
    public function postParameters(Request $request)
    {
        if ($request->ajax())
        {
            return $this->CommonMethods->getRegistrationParameters($request->country);
        }
    }

    /* * * Reset Password - Step 4 * * */
    public function getQuestion()
    {
        /* Obtener Pregunta Secreta */
        $question_id = SecurityQuestionsCountry::selectQuestionCountry(Session::get('portal.eo_reset.country'), Session::get('portal.eo_reset.distQuestion'));

        /* Vista Step 4 */
        return view('cms::frontend.reset.step4', [
            'brand'     => Session::get('portal.main.brand.name'),
            'question'  => ($question_id != null || $question_id != '') ? $question_id->name : '',
        ]);
    }

    /* * * Reset Password - Validar Respuesta * * */
    public function postQuestion(Request $request)
    {
        if ($request->ajax())
        {
            /* Validación de Campos */
            $rules = [
                'answer'    => 'required'
            ];

            $messages = [
                'answer.required'   => trans('cms::reset_password.fields.required'),
            ];

            $labels = [
                'answer' => trans('cms::reset_password.step4.answer')
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $labels);

            /* Si no cumplen con las reglas se envian los mensajes de error */
            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            $answerRest = Session::get('portal.eo_reset.distAnswer');
            $answerRequest = $request->answer;

            /* Validamos si la respuesta es correcta */
            if ($answerRequest != trim($answerRest))
            {
                /* Enviamos Mensaje de Error*/
                return response()->json([
                    'success'   => 'errors_corbiz',
                    'message'   => [
                        0   => [
                            'messUser'  => trans('cms::reset_password.step4.error_answer'),
                        ],
                    ],
                ]);
            }

            /* Redirigir a Step 5 */
            return response()->json([
                'success'   => true,
                'message'   => route('resetpassword.new_password'),
            ]);
        }
    }

    /* * * Reset Password - Step 5 * * */
    public function getNewPassword()
    {
        /* Vista Step 5 */
        return view('cms::frontend.reset.step5', [
            'brand' => Session::get('portal.main.brand.name'),
        ]);
    }

    /* * * Reset Password - Validar New Password * * */
    public function postNewPassword(Request $request)
    {
        if ($request->ajax())
        {
            /* Validación de Campos */
            $rules = [
                'new_password'          => 'required|min:4|same:new_password_confirm',
                'new_password_confirm'  => 'required|min:4',
            ];

            $messages = [
                'new_password.required'         => trans('cms::reset_password.fields.required'),
                'new_password.min'              => trans('cms::reset_password.fields.min'),
                'new_password.same'             => trans('cms::reset_password.fields.same'),
                'new_password_confirm.required' => trans('cms::reset_password.fields.required'),
                'new_password_confirm.min'      => trans('cms::reset_password.fields.min'),
            ];

            $labels = [
                'new_password'          => trans('cms::reset_password.step5.new_password'),
                'new_password_confirm'  => trans('cms::reset_password.step5.new_password_confirm'),
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $labels);

            /* Si no cumplen con las reglas se envian los mensajes de error */
            if ($validator->fails())
            {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->getMessageBag()->toArray(),
                ]);
            }

            $data = [
                'CountryKey'    => Session::get('portal.main.country_corbiz'),
                'Lang'          => Session::get('portal.main.language_corbiz'),
                'DistId'        => Session::get('portal.eo_reset.distId'),
                'Password'      => $request->new_password,
            ];

            /* Realizamos la Actualización del Password con el Servicio resetPassword */
            $resultRest = $this->resetPassword($data);

            if ($resultRest['success'] == true)
            {
                /* Obtenemos la información del usuario almacenada en la sesión */
                $distributor = Session::get('portal.eo_reset');

                /* Obtenemos el mail en base al país para enviar confirmación de cambio de contraseña */
                $emailsSend = Config::get('cms.email_send');
                $emailSend  = $emailsSend[Session::get('portal.eo_reset.country')];

                /* Realizamos el envío del mail al usuario de actualización de contraseña */
                Mail::send('cms::frontend.reset.confirmation', ['distributor' => $distributor], function ($m) use ($distributor, $emailSend) {
                    $m->from($emailSend, trans('cms::reset_password.email.title'));
                    $m->to('daniel.herrera@omnilife.com'/*$distributor['email']*/, $distributor['distName'])->subject(trans('cms::reset_password.email.subject'));
                });

                return response()->json([
                    'success'   => true,
                    'message'   => $resultRest['message'],
                ]);
            }
            else
            {
                return response()->json([
                    'success'   => 'errors_corbiz',
                    'message'   => $resultRest['message'],
                ]);
            }
        }
    }

    /* * * Reset Password - Actualizar Password * * */
    public function resetPassword($data)
    {
        /* Servicio resetPassword para actualizar contraseña */
        $urlRest        = Session::get('portal.main.webservice');
        $restWrapper    = new RestWrapper($urlRest."resetPassword");
        $params         = [
            'request' => [
                'EntrepreneurParams' => [
                    'ttEntrepreneurParams' => [
                        [
                            'CountryKey'    => $data['CountryKey'],
                            'Lang'          => $data['Lang'],
                            'DistId'        => $data['DistId'],
                            'Password'      => $data['Password'],
                        ]
                    ]
                ]
            ]
        ];

        $result = $restWrapper->call("POST", $params, 'json', ['http_errors' => false]);

        /* Validamos si el acceso al Servicio fue correcto y si la respuesta no viene vacia */
        if ($result['success'] == true && isset($result['responseWS']['response']['Success']))
        {
            /* Guardamos el Lenguage y Contraseña en la sesión para el auto login */
            Session::put('portal.eo_reset.Lang', $data['Lang']);
            Session::put('portal.eo_reset.Password', $data['Password']);

            /* Redirección al siguiente paso */
            return [
                'success'   => true,
                'message'   => route('resetpassword.info_user'),
            ];
        }
        /* Validamos si el acceso al Servicio fue incorrecto y si la respuesta de error no viene vacia */
        else if ($result['success'] == false && isset($result['responseWS']['response']['Error']['dsError']['ttError']))
        {
            /* Se envía el mensaje de error del Servicio */
            return [
                'success'   => 'errors_corbiz',
                'message'   => $result['responseWS']['response']['Error']['dsError']['ttError'],
            ];
        }
        /* Si el Servicio no esta funcionando */
        else
        {
            /* Se envia mensaje de falla de Servicio */
            return [
                'success'   => 'errors_corbiz',
                'message'   => [
                    0   => [
                        'messUser'  => trans('cms::reset_password.error_rest'),
                    ]
                ],
            ];
        }
    }

    /* * * Reset Password - Validar a que opcion a regresar * * */
    public function getBackNewPassword()
    {
        /* Si opcion es igual a 1 redirigir a vista Step 3.1 */
        if (Session::get('portal.eo_reset.option') == 1)
        {
            return response()->json([
                'success'   => true,
                'message'   => route('resetpassword.code'),
            ]);
        }
        /* Si opcion es igual a 0 redirigir a vista Step 3.2 */
        else
        {
            return response()->json([
                'success'   => true,
                'message'   => route('resetpassword.question'),
            ]);
        }
    }

    /* * * Reset Password - Obtener la información del usuario para auto login * * */
    public function getInfoUser()
    {
        $distId     = Session::get('portal.eo_reset.distId');
        $password   = Session::get('portal.eo_reset.Password');
        $country    = Session::get('portal.eo_reset.country');
        $lang       = Session::get('portal.eo_reset.Lang');

        Session::forget('portal.eo_reset');

        return redirect('/resetpassword/login')->with('code', $distId)->with('password', $password)->with('country', $country)->with('lang', $lang);
    }

    /* * * Reset Password - Step 6 * * */
    public function getLogin()
    {
        /* Vista Step 6 */
        return view('cms::frontend.reset.step6', [
            'brand' => Session::get('portal.main.brand.name'),
        ]);
    }

    /* * * Reset Password - Reenvio de Código * * */
    public function getSendCode()
    {
        /* Generamos Código de Verificación */
        $codeReset = new CodeReset();

        $code = $codeReset->getCodeReset([
            'distId'    => Session::get('portal.eo_reset.distId'),
            'length'    => 8,
        ]);

        /* Actualizamos el código en la sesión eo_reset.code */
        Session::put('portal.eo_reset.code', $code);

        /* Obtenemos la información del usuario almacenada en la sesión */
        $distributor = Session::get('portal.eo_reset');

        /* Obtenemos el mail en base al país para el envío del código */
        $emailsSend = Config::get('cms.email_send');
        $emailSend  = $emailsSend[Session::get('portal.eo_reset.country')];

        /* Realizamos el envío del mail al usuario */
        Mail::send('cms::frontend.reset.restore', ['distributor' => $distributor], function ($m) use ($distributor, $emailSend) {
            $m->from($emailSend, trans('cms::reset_password.email.title'));
            $m->to('jose.osuna@omnilife.com'/*$distributor['email']*/, $distributor['distName'])->subject(trans('cms::reset_password.email.subject'));
        });

        return response()->json([
            'success'   => true
        ]);
    }
}