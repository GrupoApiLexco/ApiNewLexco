<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;

$version = config('app.api_version');

// Rutas públicas
Route::post('/test', [AuthController::class, 'test']); // Endpoint para verificar el estado de la API
Route::post('/login', [AuthController::class, 'login']); // Endpoint de inicio de sesión

// Rutas protegidas
Route::middleware(['auth:sanctum', 'active.user'])->group(function () use ($version) {
    // Rutas de administración
    Route::prefix("$version/admin")
        ->middleware(AdminMiddleware::class) // Middleware que restringe acceso solo a administradores
        ->group(function () {
            Route::post('/users/add', [UserController::class, 'store']); // Crear usuario
            Route::get('/users', [UserController::class, 'index']); // Listar usuarios
            Route::post('/users/{user}', [UserController::class, 'show']); // Mostrar detalles de un usuario
            Route::patch('/users/{user}/status', [UserController::class, 'toggleStatus']); // Cambiar estado de usuario
        });

    // Rutas generales de usuario
    Route::prefix($version)->group(function () {
        Route::put('/users/{user}', [UserController::class, 'update']); // Actualizar usuario
        Route::post('/users/image', [UserController::class, 'uploadImage']); // Subir imagen de usuario
        Route::get('/users/image/{filename}', function ($filename) {
            return response()->file(storage_path("app/public/user_image/$filename")); // Retornar imagen almacenada
        })->where('filename', 'user_\d+\.(png|jpg|jpeg)'); // Validación del formato del nombre del archivo
    });
});
