<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $role_unpack = explode("|", $role);
        $module = $role_unpack[0];
        $action = $role_unpack[1];
        if (\Auth::check() && \RolesManagement::role($module, $action)) {
            return $next($request);
        }
        else
        {
            // return abort(404);
            // return redirect('/');
            return redirect('/');
        }
    }
}
