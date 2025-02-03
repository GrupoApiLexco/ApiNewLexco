<?php

namespace App\Exceptions;

use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InactiveUserException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Lista de tipos de excepciones que no son reportadas
     * Estos errores no serán registrados en los logs.
     */
    protected $dontReport = [
        // Agregar aquí excepciones que no se deben reportar
    ];

    /**
     * Lista de inputs que nunca serán guardados en la sesión durante excepciones de validación
     * Protege información sensible de ser expuesta en errores.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registra los callbacks para el manejo de excepciones
     * Aquí se definen respuestas personalizadas para errores específicos.
     */
    public function register(): void
    {
        // Manejo de la excepción InvalidCredentialsException
        $this->renderable(function (InvalidCredentialsException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        });

        // Manejo de la excepción InactiveUserException
        $this->renderable(function (InactiveUserException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        });

        // Manejo de la excepción InactiveUserException con namespace completo
        $this->renderable(function (\App\Exceptions\InactiveUserException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        });
    }
}
