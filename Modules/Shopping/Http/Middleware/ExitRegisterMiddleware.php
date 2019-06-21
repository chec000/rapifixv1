<?php

namespace Modules\Shopping\Http\Middleware;

use App\Helpers\SessionHdl;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class ExitRegisterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!SessionHdl::hasEo() && (Session::has('portal.register_customer') || Session::has('portal.register')))
        {
            $url_current            = url()->current();
            $url_previous           = url()->previous();
            $url_previous_segment   = explode('/', $url_previous);
            $prefix                 = Config::get('shopping.exit_modal');

            if (count($url_previous_segment) > 3)
            {
                if (Session::has('portal.request_businessman') && Session::get('portal.request_businessman') == true)
                {
                    $segment = explode('?', $url_previous_segment[3]);
                    $url_prefix = $segment[0];
                }
                else if (Session::has('portal.register_customer.activation') && Session::get('portal.register_customer.activation') == true)
                {
                    if (Session::get('portal.register_customer.activation_option') == true)
                    {
                        Session::put('portal.register_customer.activation_option', false);

                        return $next($request);
                    }
                    else
                    {
                        # Parche 12/oct/2018
                        # Corrige el error cuando justo después de iniciar sesión un cliente admirable recien registrado
                        # dependiendo de la url anterior, truena al intentar obtener el indice 4 cuando no existe.
                        # Ejem: [0 => 'https', 1 => '', 2 => 'portal.omnilife.com', 3 => 'products']
                        Session::put('portal.register_customer.activation_option', false);
                        if (isset($url_previous_segment[4])) {
                            $segment = explode('?', $url_previous_segment[4]);
                            $url_prefix = $segment[0];
                        } else if (isset($url_previous_segment[3])) {
                            $segment = explode('?', $url_previous_segment[3]);
                            $url_prefix = $segment[0];
                        } else {
                            $url_prefix = 'start';
                        }
                    }
                }
                else
                {
                    $url_prefix = $url_previous_segment[3];
                }

                if (!Session::has('portal.unfinished_register'))
                {
                    foreach ($prefix as $p => $ns)
                    {
                        if ($url_prefix == $p)
                        {
                            $data = '';
                            $step = '';

                            if (Session::has('portal.' . $ns . '.step'))
                            {
                                $step = Session::get('portal.' . $ns . '.step');
                            }

                            if (Session::has('portal.register_customer.data'))
                            {
                                $data = json_encode(Session::get('portal.register_customer.data'));
                            }
                            else if (Session::has('portal.register.steps'))
                            {
                                $data = json_encode(Session::get('portal.register.steps'));
                            }

                            return redirect()->back()->with('modalExit', true)->with('stepUnfinished', $step)->with('dataUnfinished', $data)->with('urlNextExitRegister', $url_current)->with('nameSession', $ns);
                        }
                        else if ($url_prefix == 'activation')
                        {
                            $data = '';
                            $step = '';

                            return redirect()->back()->with('modalExit', true)->with('stepUnfinished', $step)->with('dataUnfinished', $data)->with('urlNextExitRegister', $url_current)->with('nameSession', 'register_customer');
                        }
                    }
                }
                else
                {
                    Session::forget('portal.register');
                    Session::forget('portal.register_customer');
                    Session::forget('portal.unfinished_register');
                    Session::forget('portal.request_businessman');
                }
            }
        }

        return $next($request);
    }
}