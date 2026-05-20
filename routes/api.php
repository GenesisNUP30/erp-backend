<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ParcelaController;
use App\Http\Controllers\Api\CampaniaController;
use App\Http\Controllers\Api\PlantacionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VariedadController;
use App\Http\Controllers\Api\CosechaController;
use App\Http\Controllers\Api\RecoleccionController;
use App\Http\Controllers\Api\HorasTrabajadaController;
use App\Http\Controllers\Api\PagoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/login', [AuthController::class, 'login']);

// Rutas publicas para poder ver los datos de la api

// TRABAJADORES
Route::get('/trabajadores', [UserController::class, 'index']);
Route::get('/trabajadores/{id}', [UserController::class, 'show']);

// Rutas para selects de plantaciones
Route::get('/parcelas/activas', [ParcelaController::class, 'activas']);
Route::get('/variedades/todas', [VariedadController::class, 'todas']);
Route::get('/campanias/activas', [CampaniaController::class, 'activas']);

// PARCELAS
Route::get('/parcelas', [ParcelaController::class, 'index']);
Route::get('/parcelas/{id}', [ParcelaController::class, 'show']);

// CAMPAÑAS
Route::get('/campanias', [CampaniaController::class, 'index']);
Route::get('/campanias/{id}', [CampaniaController::class, 'show']);

// VARIEDADES
Route::get('/variedades', [VariedadController::class, 'index']);
Route::get('/variedades/{id}', [VariedadController::class, 'show']);

// PLANTACIONES
Route::get('/plantaciones', [PlantacionController::class, 'index']);
Route::get('/plantaciones/{id}', [PlantacionController::class, 'show']);

// COSECHAS
Route::get('/cosechas', [CosechaController::class, 'index']);
Route::get('/cosechas/activas', [CosechaController::class, 'activas']);
Route::get('/cosechas/{id}', [CosechaController::class, 'show']);
Route::get('/cosechas/{id}/resumen-recolecciones', [RecoleccionController::class, 'resumenPorCosecha']);

// RECOLECCIONES
Route::get('/recolecciones', [RecoleccionController::class, 'index']);
Route::get('/recolecciones/{id}', [RecoleccionController::class, 'show']);

// Rutas protegidas, solo para usuarios autenticados
Route::middleware('auth:sanctum')->group(function () {
    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index']);

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

    // VARIEDADES
    Route::post('/variedades', [VariedadController::class, 'store']);
    Route::put('/variedades/{id}', [VariedadController::class, 'update']);
    Route::delete('/variedades/{id}', [VariedadController::class, 'destroy']);

    // PLANTACIONES
    Route::post('/plantaciones', [PlantacionController::class, 'store']);
    Route::put('/plantaciones/{id}', [PlantacionController::class, 'update']);
    Route::delete('/plantaciones/{id}', [PlantacionController::class, 'destroy']);

    // COSECHAS
    Route::post('/cosechas', [CosechaController::class, 'store']);
    Route::put('/cosechas/{id}', [CosechaController::class, 'update']);
    Route::delete('/cosechas/{id}', [CosechaController::class, 'destroy']);

    // RECOLECCIONES
    Route::post('/recolecciones', [RecoleccionController::class, 'store']);
    Route::put('/recolecciones/{id}', [RecoleccionController::class, 'update']);
    Route::delete('/recolecciones/{id}', [RecoleccionController::class, 'destroy']);

    // HORAS TRABAJADAS
    Route::get('/horas-trabajadas', [HorasTrabajadaController::class, 'index']);
    Route::post('/horas-trabajadas', [HorasTrabajadaController::class, 'store']);
    Route::get('/horas-trabajadas/{id}', [HorasTrabajadaController::class, 'show']);
    Route::put('/horas-trabajadas/{id}', [HorasTrabajadaController::class, 'update']);
    Route::delete('/horas-trabajadas/{id}', [HorasTrabajadaController::class, 'destroy']);
    Route::get('/horas-trabajadas/resumen-mensual', [HorasTrabajadaController::class, 'resumenMensual']);

    // PAGOS
    Route::get('/pagos', [PagoController::class, 'index']);
    Route::post('/pagos', [PagoController::class, 'store']);
    Route::get('/pagos/generar-borrador', [PagoController::class, 'generarBorrador']);
    Route::get('/pagos/{id}', [PagoController::class, 'show']);
    Route::put('/pagos/{id}', [PagoController::class, 'update']);
    Route::delete('/pagos/{id}', [PagoController::class, 'destroy']);
});
