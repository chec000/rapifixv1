<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class LanguageMiddleware
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
         if ( \Session::has('adminLocale') && Auth::check() ) {
                 \App::setLocale(\Session::get('adminLocale'));
        } else {
            \App::setLocale(config('admin.locale.defaultLocale'));
        }
        
        return $next($request);
    }
}
