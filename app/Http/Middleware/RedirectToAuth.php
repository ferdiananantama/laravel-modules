<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // kalau akses root "/"
        if ($request->path() === '/') {
            return redirect()->route('auth.index');
        }

        return $next($request);
    }
}
