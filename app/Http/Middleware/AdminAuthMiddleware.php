<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(!empty(Auth::user())){
            if(url()->current() == route('auth#loginPage') || url()->current() == route('auth#registerPage')){
                return back();
            }
             // Check if the user is authenticated and has an 'admin' role
            if (!Auth::check() || Auth::user()->role != 'admin') {
                return abort(403, 'Unauthorized access.');
            }

            return $next($request);
        }
        return $next($request);
    }



}
