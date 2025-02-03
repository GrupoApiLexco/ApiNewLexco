<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Validators\UserValidator;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // Constructor que inyecta el servicio UserService en el controlador
    public function __construct(
        protected UserService $userService
    ) {}

    // Método para obtener todos los usuarios
    public function index()
    {
        // Devuelve todos los usuarios en formato JSON
        return response()->json(User::all());
    }

    // Método para crear un nuevo usuario
    public function store(Request $request)
    {
        // Valida los datos recibidos en la solicitud usando el validador UserValidator
        $validator = UserValidator::validateCreate($request->all());
        
        // Si la validación falla, devuelve un error con los detalles de la validación
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Si la validación es exitosa, crea el usuario utilizando el servicio UserService
        return response()->json($this->userService->createUser($request->all()));
    }

    // Método para obtener los detalles de un usuario específico
    public function show(User $user)
    {
        // Devuelve los detalles del usuario en formato JSON
        return response()->json($user);
    }

    // Método para actualizar los datos de un usuario
    public function update(Request $request, User $user)
    {
        // Valida los datos recibidos para la actualización del usuario
        $validator = UserValidator::validateUpdate($request->all());
        
        // Si la validación falla, devuelve un error con los detalles de la validación
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Si la validación es exitosa, actualiza el usuario utilizando el servicio UserService
        return response()->json($this->userService->updateUser($user, $request->all()));
    }

    // Método para cambiar el estado del usuario (habilitar/deshabilitar)
    public function toggleStatus(User $user)
    {
        // Cambia el estado del usuario utilizando el servicio UserService y lo devuelve en formato JSON
        return response()->json($this->userService->toggleStatus($user));
    }

    // Método para cargar una imagen para el usuario
    public function uploadImage(Request $request)
    {
        // Valida la imagen recibida en la solicitud
        $validator = UserValidator::validateImage($request->all());
        
        // Si la validación falla, devuelve un error con los detalles de la validación
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Si la validación es exitosa, sube la imagen y devuelve la ruta de la imagen cargada
        return response()->json([
            'path' => $this->userService->uploadImage($request->user(), $request->file('image'))
        ]);
    }
}
