<?php

namespace App\Models; // Define el espacio de nombres para el modelo User.

use Illuminate\Support\Facades\Hash; // Proporciona métodos para encriptar contraseñas.
use Laravel\Sanctum\HasApiTokens; // Habilita la autenticación mediante tokens API.
use Illuminate\Foundation\Auth\User as Authenticatable; // Extiende la funcionalidad de autenticación de Laravel.
use Illuminate\Database\Eloquent\Factories\HasFactory; // Permite generar datos de prueba mediante factories.

class User extends Authenticatable
{
    use HasApiTokens, HasFactory; // Incluye los traits para tokens API y generación de factories.
    
    /*Estados posibles de un usuario.*/
    
    const STATUS_ACTIVE = 1; // Estado que indica que el usuario está activo.
    const STATUS_INACTIVE = 0; // Estado que indica que el usuario está inactivo.

    protected $fillable = [
        'name', // Nombre del usuario.
        'surnames', // Apellidos del usuario.
        'email', // Correo electrónico del usuario.
        'password', // Contraseña del usuario (debe ser encriptada antes de guardarla).
        'status', // Estado del usuario (activo o inactivo).
        'role' // Rol del usuario dentro del sistema (ejemplo: admin, user).
    ];
}
