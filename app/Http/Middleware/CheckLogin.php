<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user')) {
            return redirect()->route('auth.login'); // redirect ke login
        }

        return $next($request);
    }
}
