<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Auth::check();
        $user = Auth::user()->id;

        if (!$request->session()->has('administrador_id')) {
            return redirect()->route('administrador.login');
        }

    }
}
