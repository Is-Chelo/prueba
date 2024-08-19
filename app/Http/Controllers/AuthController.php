<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Models\User;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * @group Autentificacion
 * 
 */
class AuthController extends Controller
{
    /**
     * Login de un usuario
     *
     * Proceso para obtener la autorizacion para consumir las apis
     *
     *
     * @bodyParam email string required
     * Email del Usuario Example: admin@gmail.com
     *
     * @bodyParam password string required
     * Password del Usuario Example: 12345678
     *
     * @responseFile 200 responses/login.json
     *
     *
     */
    // TODO: Pasar a patron repositorio...
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == null) return ApiResponseService::unauthorized('El usuario no existe, por favor debe registrarse');

        $credentials = [
            'email' => $user->email,
            'password' => trim($request->password)
        ];

        try {
            if (!Auth::attempt($credentials)) {
                return response()->json(['status' => false, 'message' => 'Su usuario y contraseña no coinciden.', 'errors' => ['Unauthorized']], 401);
            }
            $token = Auth::user()->createToken(env('APP_KEY', 'myapptoken'))->plainTextToken;
        } catch (ValidationException $e) {
            return response()->json(['status' => false, 'message' => 'Hubo un error, vuelva a intentarlo.', 'errors' => ['Error en el servidor']], 500);
        }

        $date = now()->addMonths(6);

        return ApiResponseService::success('Login correcto.', [
            'token' => $token,
            'expiration_date' => $date,
            'user' => new LoginResource($user)
        ]);
    }
}
