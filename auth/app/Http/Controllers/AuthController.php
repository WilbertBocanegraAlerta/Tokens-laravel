<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignInRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * constructor donde pasamos los middleware que queremos que evalue y que metodos no tiene que aplica
     */
    public function __construct()
    {
        $this->middleware(['jwt', 'refresh'])->except('login', 'signin');
    }

    /**
     * Inicio de sesión con credenciales respondiendo con información si es correcta y envio de token
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = auth()->attempt($credentials);

        if (!$token) {
            return response()->json(["msg" => "Credenciales invalidas", 'error' => 'Unauthorized'], 401);
        }

        $auth = auth()->user();

        $user = ["name" => $auth->name, "lastname" => $auth->lastname, "email" => $auth->email, "role" => $auth->getRoleNames()];

        return response()->json(["msg" => "login successfully", "data" => $user])->withHeaders([
            'TTL' => auth()->factory()->getTTL() * 60,
            'TOKEN' => $token
        ]);
    }

    /**
     * Registro de nueva cuenta al sistema y asignacion de un rol
     */
    public function signin(SignInRequest $request)
    {

        $formData = $request->only('name', 'lastname', 'email', 'password');
        $user = new User($formData);
        $user->password = Hash::make($user->password);
        $user->save();

        $user->assignRole('user');

        return response()->json(["user" => $user]);
    }

    /**
     * Metodo para cerrar sesión del sistema
     */
    public function logout()
    {
        try {
            //code...
            auth()->logout();
            return response()->json(['msg' => 'logout', "data" => []]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(["msg" => $th->getMessage(), "data" => []], 400);
        }
    }

    /**
     * Metodo para obtener toda la información del usuario que inicio sesión
     */
    public function getAuth(Request $request)
    {
        $user = auth()->user();

        return response()->json(["msg" => "sucessfully", "data" => [
            "name" => $user->name,
            "lastname" => $user->lastname,
            "email" => $user->email,
            "role" => $user->getRoleNames()
        ]]);
    }
}
