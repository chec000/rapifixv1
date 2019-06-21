<?php

namespace Modules\CMS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class Authenticate
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
        if (!Session::has('portal.eo.auth') && Session::get('portal.main.shopping_active') == 1 && Config::get('settings::frontend.webservices') == 1)
        {
            $prefix = Config::get('cms.prefix_redirect');

            foreach ($prefix as $p)
            {
                if (Route::current()->getPrefix() == $p)
                {
                    if ($request->ajax() || $request->wantsJson())
                    {
                        return response('Unauthorized', 401);
                    }
                    else
                    {
                        $url_previous = '/' . Route::current()->uri();

                        return redirect('/')->with('sectionLogin', true)->with('url_previous', $url_previous);
                    }
                }
                else if (Route::current()->getPrefix() == 'shopping') {
                    $country_corbiz = Session::get('portal.main.country_corbiz');
                    $url_next       = route('checkout.index');

                    if (Session::has('portal.cart.' . $country_corbiz . '.items'))
                    {
                        $items      = count(Session::get('portal.cart.' . $country_corbiz . '.items'));
                    }
                    else
                    {
                        $items      = 0;
                    }

                    if ($items > 0)
                    {
                        $url_previous = url()->previous();
                        $url_previous_segment = explode('/', $url_previous);

                        if ($url_previous_segment[3] == 'shopping')
                        {
                            return redirect('/');
                        }
                        else
                        {
                            return redirect('/')->with('modalLogin', true)->with('url_previous', $url_next);
                        }
                    }
                    else
                    {
                        return redirect('/')->with('sectionLogin', true)->with('url_previous', $url_next);
                    }
                }
            }
        }

        return $next($request);
    }
}