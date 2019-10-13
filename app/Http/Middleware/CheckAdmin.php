<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Session::get('is_admin')) {
            return $next($request);
        } else {
            return redirect('')->with('error','You have not permissions');
        }
    }
}
