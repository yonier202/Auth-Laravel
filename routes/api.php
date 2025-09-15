<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::post('/create', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function(){

    Route::post('/logout', [AuthController::class, 'logout']);

    //devuelve el usuario autenticado basado en el token
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('/users', UserController::class);
});
