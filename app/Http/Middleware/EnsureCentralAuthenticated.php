<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCentralAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('central.login');
        }

        if (! Auth::user()->hasRole('Admin')) {
            abort(403, 'Acesso permitido apenas para administradores.');
        }

        return $next($request);
    }
}
