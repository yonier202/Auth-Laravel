<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json([
            'users' => $users
        ], 200);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'user' => $user
        ], 200);
    }
}
