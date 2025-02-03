<?php

namespace App\Exceptions;

use Exception;

/**
 * Excepción para usuario inactivo.
 */
class InactiveUserException extends Exception {
    protected $message = 'Usuario inactivo';
    protected $code = 403; // Prohibido
}

/**
 * Excepción para credenciales inválidas.
 */
class InvalidCredentialsException extends Exception {
    protected $message = 'Credenciales inválidas';
    protected $code = 401; // No autorizado
}
