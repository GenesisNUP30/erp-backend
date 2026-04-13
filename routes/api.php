<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ParcelaController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) { return $request->user(); });
});

Route::post('/login', [AuthController::class, 'login']);

// Rutas publicas para poder ver los datos de la api
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/trabajadores', [UserController::class, 'index']);
Route::get('/trabajadores/{id}', [UserController::class, 'show']);

Route::get('/parcelas', [ParcelaController::class, 'index']);
Route::get('/parcelas/{id}', [ParcelaController::class, 'show']);

// Rutas protegidas, solo para usuarios autenticados
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/trabajadores', [UserController::class, 'store']);
    Route::put('/trabajadores/{id}', [UserController::class, 'update']);
    Route::delete('/trabajadores/{id}', [UserController::class, 'destroy']);

    Route::post('/parcelas', [ParcelaController::class, 'store']);
    Route::put('/parcelas/{id}', [ParcelaController::class, 'update']);
    Route::delete('/parcelas/{id}', [ParcelaController::class, 'destroy']);
});