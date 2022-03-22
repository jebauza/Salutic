<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class CheckUserAuth
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
        if (!empty(session('authId'))) {
            auth()->login(User::find(session('authId')));
        }
        return $next($request);
    }
}
