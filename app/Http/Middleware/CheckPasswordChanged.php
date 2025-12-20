<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPasswordChanged
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->password_changed) {
            return redirect()->route('password.change')
                ->with('error', 'You need to change your password before accessing this page.');
        }

        return $next($request);
    }
}
