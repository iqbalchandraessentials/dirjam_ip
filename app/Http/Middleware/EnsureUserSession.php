<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class EnsureUserSession
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }

        return $next($request);
    }
}
