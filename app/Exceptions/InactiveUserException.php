<?php

namespace App\Exceptions;

use Exception;

/* Excepción personalizada para indicar que un usuario está inactivo. 
 * Se lanza cuando un usuario intenta acceder a la aplicación pero su cuenta está inactiva.
 */
class InactiveUserException extends Exception {
    /* Este mensaje se mostrará cuando la excepción sea capturada.*/
    protected $message = 'Usuario inactivo';
    /* 
     * En este caso, 403 indica "Prohibido" */
    protected $code = 403;
}
