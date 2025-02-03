<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class ActiveUser
{
    /**Maneja la solicitud entrante
     * Esta función verifica si el usuario autenticado tiene un estado activo.
     * Si el usuario no está activo, se devuelve una respuesta con un mensaje
     * indicando que la cuenta está inactiva y un código de estado HTTP 403.
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado y si su estado no es "activo"
        if ($request->user() && $request->user()->status !== User::STATUS_ACTIVE) {
            // Si el estado no es activo, devuelve una respuesta con mensaje de error y código 403
            return response()->json([
                'message' => 'Cuenta inactiva'  // Mensaje informando que la cuenta está inactiva
            ], 403); // Código de estado HTTP 403 (Forbidden)
        }

        // Si el usuario está activo, pasa la solicitud al siguiente middleware o controlador
        return $next($request);
    }
}
