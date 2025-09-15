<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRequest $request): JsonResponse
    {
        try {
            $user =User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'isActive' => $request->isActive ?? true,
                'roles' => $request->roles ?? ['user'],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 401);
        }

        return response()->json([
            'status' => 'succes',
            'token' => $user->createToken('Api Token')->plainTextToken,
            'data' => $user,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'status' => 'error',
                'message' => 'Credenciales incorrectas'
            ], 401);
        }
        $user = Auth::user();

        return response()->json([
            'status' => 'succes',
            'token' => $user->createToken('Api Token')->plainTextToken,
            'data' => $user
        ], 200);
    }

    //recibe la peticion pera eliminar el token
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'succes'
        ], 200);
    }
}
