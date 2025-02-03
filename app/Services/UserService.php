<?php

namespace App\Services; // Define el espacio de nombres para los servicios de usuario.

use App\Models\User; // Importa el modelo User para gestionar usuarios.
use Illuminate\Support\Facades\Storage; // Importa Storage para manejar archivos.

class UserService
{
    /**
     * Crea un nuevo usuario con los datos proporcionados.
     */
    public function createUser(array $data): User
    {
        $data['password'] = bcrypt($data['password']); // Encripta la contraseña antes de guardarla.
        return User::create($data); // Crea y retorna el usuario.
    }

    /**
     * Actualiza la información de un usuario existente.
     */
    public function updateUser(User $user, array $data): User
    {
        if (isset($data['password'])) { // Si se proporciona una nueva contraseña, se encripta.
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data); // Actualiza los datos del usuario.
        return $user;
    }

    /**
     * Cambia el estado de un usuario (activo/inactivo).
     */
    public function toggleStatus(User $user): User
    {
        $user->update(['status' => !$user->status]); // Invierte el estado actual.
        return $user;
    }

    /**
     * Sube una imagen de perfil para el usuario y guarda la ruta.
     */
    public function uploadImage(User $user, $image): string
    {
        $path = "user_image/user_{$user->id}.".$image->extension(); // Define la ruta de almacenamiento.
        Storage::disk('public')->put($path, file_get_contents($image)); // Guarda la imagen en el almacenamiento público.
        $user->update(['image_path' => $path]); // Guarda la ruta en la base de datos.
        return $path;
    }
}

