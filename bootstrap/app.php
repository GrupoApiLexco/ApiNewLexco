<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__)) // Configura la aplicación con la ruta base del proyecto
    ->withRouting(
        web: __DIR__.'/../routes/web.php',      // Archivo de rutas web (para vistas y controladores)
        api: __DIR__.'/../routes/api.php',      // Archivo de rutas API (para endpoints de la API)
        commands: __DIR__.'/../routes/console.php', // Archivo de rutas para comandos de consola personalizados
        health: '/up', // Ruta para verificar el estado de la aplicación
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Define los middleware del grupo "api"
        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Maneja la autenticación de Laravel Sanctum
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Permite la inyección automática de modelos en rutas
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Aquí se pueden definir excepciones personalizadas
    })
    ->create(); // Crea y devuelve la instancia de la aplicación
