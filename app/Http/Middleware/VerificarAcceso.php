<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Middleware\VerificarAcceso;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

// Encryption Key

class VerificarAcceso{

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->query('acceso') !== '1234') {
            return response('Acceso denegado', 403);
        }

        return $next($request);
    }
}
