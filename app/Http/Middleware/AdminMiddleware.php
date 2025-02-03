<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /*Verifica si el usuario tiene rol de administrador. */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario es administrador
        if ($request->user()?->role !== 'admin') {
            return response()->json([
                'message' => 'Acceso no autorizado'
            ], 403);
        }

        return $next($request);
    }
}
