<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ParcelaController;
use App\Http\Controllers\Api\CampaniaController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) { return $request->user(); });
});

Route::post('/login', [AuthController::class, 'login']);

// Rutas publicas para poder ver los datos de la api
// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index']);

// TRABAJADORES
Route::get('/trabajadores', [UserController::class, 'index']);
Route::get('/trabajadores/{id}', [UserController::class, 'show']);

// PARCELAS
Route::get('/parcelas', [ParcelaController::class, 'index']);
Route::get('/parcelas/{id}', [ParcelaController::class, 'show']);

// CAMPAÑAS
Route::get('/campanias', [CampaniaController::class, 'index']);
Route::get('/campanias/{id}', [CampaniaController::class, 'show']);

// Rutas protegidas, solo para usuarios autenticados
Route::middleware('auth:sanctum')->group(function () {
    // TRABAJADORES
    Route::post('/trabajadores', [UserController::class, 'store']);
    Route::put('/trabajadores/{id}', [UserController::class, 'update']);
    Route::delete('/trabajadores/{id}', [UserController::class, 'destroy']);

    // PARCELAS
    Route::post('/parcelas', [ParcelaController::class, 'store']);
    Route::put('/parcelas/{id}', [ParcelaController::class, 'update']);
    Route::delete('/parcelas/{id}', [ParcelaController::class, 'destroy']);

    // CAMPAÑAS
    Route::post('/campanias', [CampaniaController::class, 'store']);
    Route::put('/campanias/{id}', [CampaniaController::class, 'update']);
    Route::delete('/campanias/{id}', [CampaniaController::class, 'destroy']);
});