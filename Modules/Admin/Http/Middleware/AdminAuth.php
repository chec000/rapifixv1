<?php namespace Modules\Admin\Http\Middleware;

use Auth;
use Closure;
use Request;

class AdminAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeParts = explode('.', Request::route()->getName());
        
        if (Auth::check()) {

            if ( empty($routeParts[0]) || $routeParts[0] != 'admin') {
                return abort(403, 'Not a CoasterCMS admin route');
            }

            $controller = !empty($routeParts[1]) ? $routeParts[1] : null;
            $action = !empty($routeParts[2]) ? $routeParts[2] : null;
            $parameters = $request->route()->parameters();
            if (Auth::actionRoute($controller, $action, $parameters) || $request->ajax()) {
                return $next($request);
            } elseif (Auth::admin()) {
                return abort(403, 'Action not permitted');
            }
        }

        //return \redirect()->route('admin.login')->withCookie(cookie('login_path', $request->getRequestUri()));
        return \redirect()->route('admin.login')->withCookie(cookie('login_path', $request->getUri()));
    }

}
