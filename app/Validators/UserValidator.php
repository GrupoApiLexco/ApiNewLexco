<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class UserValidator
{
    /* Valida los datos para el inicio de sesión.*/
    public static function validateLogin(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email', // El email es obligatorio y debe tener formato válido.
            'password' => 'required|string' // La contraseña es obligatoria y debe ser una cadena.
        ]);
    }

    /**
     * Valida los datos para la creación de un usuario.
     *
     * @param array $data Datos a validar.
     * @return \Illuminate\Contracts\Validation\Validator Instancia del validador.
     */
    public static function validateCreate(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255', // Nombre obligatorio, de tipo string, máx. 255 caracteres.
            'surnames' => 'required|string|max:255', // Apellidos obligatorios, tipo string, máx. 255 caracteres.
            'email' => 'required|email|unique:users', // Email obligatorio, único en la tabla users.
            'password' => 'required|string|min:8', // Contraseña obligatoria, mín. 8 caracteres.
            'role' => 'required|in:admin,vendedor,cliente' // El rol es obligatorio y debe ser uno de los valores permitidos.
        ]);
    }

    /*Valida los datos para la actualización de un usuario.*/
    public static function validateUpdate(array $data)
    {
        return Validator::make($data, [
            'name' => 'sometimes|string|max:255', // Si se proporciona, debe ser string, máx. 255 caracteres.
            'surnames' => 'sometimes|string|max:255', // Si se proporciona, debe ser string, máx. 255 caracteres.
            'email' => 'sometimes|email|unique:users,email,'.$data['id'], // Si se proporciona, debe ser único (excepto el del usuario actual).
            'password' => 'sometimes|string|min:8', // Si se proporciona, debe ser string y tener al menos 8 caracteres.
            'status' => 'sometimes|boolean' // Si se proporciona, debe ser booleano.
        ]);
    }

    /*Valida los datos para la subida de una imagen.*/
    public static function validateImage(array $data)
    {
        return Validator::make($data, [
            'image' => 'required|image|mimes:jpeg,png|max:1024' // Imagen obligatoria, solo formatos jpeg y png, máx. 1MB.
        ]);
    }
}
