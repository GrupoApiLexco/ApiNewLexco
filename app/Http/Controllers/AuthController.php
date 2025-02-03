<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Validators\UserValidator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InactiveUserException;

class AuthController extends Controller
{
    /**
     * Verifica el estado de la API.
     */
    public function test()
    {
        return response()->json([
            'version' => config('app.api_version', '1.0.0'),
            'status' => 'API operativa'
        ]);
    }

    /**
     * Maneja el proceso de inicio de sesión.
     */
    public function login(Request $request)
    {
        // Valida los datos de inicio de sesión
        $validator = UserValidator::validateLogin($request->all());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $response = null;

        try {
            // Verifica credenciales
            if (!Auth::attempt($request->only('email', 'password'))) {
                throw new InvalidCredentialsException();
            }

            // Obtiene el usuario activo
            $user = User::where('email', $request->email)
                ->where('status', User::STATUS_ACTIVE)
                ->firstOrFail();

            // Devuelve el token de autenticación
            $response = response()->json([
                'token' => $user->createToken('auth_token')->plainTextToken
            ]);
        } catch (\Exception $e) {
            $response = $this->handleLoginException($e);
        }

        return $response;
    }

    /**
     * Maneja excepciones durante el login.
     */
    private function handleLoginException(\Exception $e)
    {
        Log::error("Login Error: {$e->getMessage()}");

        return match(get_class($e)) {
            InvalidCredentialsException::class => response()->json(
                ['error' => $e->getMessage()],
                $e->getCode()
            ),
            InactiveUserException::class => response()->json(
                ['error' => $e->getMessage()],
                $e->getCode()
            ),
            default => response()->json(
                ['error' => 'Error interno del servidor'],
                500
            )
        };
    }
}
