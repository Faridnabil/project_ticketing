<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityOrRegencyController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

// Profile
Route::middleware('auth:api')->prefix('profile')->group(function () {
    Route::put('/', [ProfileController::class, 'update']); // Memperbarui profil pengguna
    Route::post('/photo', [ProfileController::class, 'updatePhoto']); // Memperbarui foto profil
});

// MASTER DATA
// Group untuk API Categories
Route::middleware('auth:api')
    ->prefix('categories')
    ->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });

// Group untuk API Priorities
Route::middleware('auth:api')
    ->prefix('priorities')
    ->group(function () {
        Route::get('/', [PriorityController::class, 'index']);
        Route::post('/', [PriorityController::class, 'store']);
        Route::put('/{id}', [PriorityController::class, 'update']);
        Route::delete('/{id}', [PriorityController::class, 'destroy']);
    });

// Group untuk API Provinces
Route::middleware('auth:api')
    ->prefix('provinces')
    ->group(function () {
        Route::get('/', [ProvinceController::class, 'index']);
        Route::post('/', [ProvinceController::class, 'store']);
        Route::get('/{id}', [ProvinceController::class, 'show']);
        Route::put('/{id}', [ProvinceController::class, 'update']);
        Route::delete('/{id}', [ProvinceController::class, 'destroy']);

        Route::get('/export-format', [ProvinceController::class, 'exportFormat']);
        Route::get('/export', [ProvinceController::class, 'export']);
        Route::post('/import', [ProvinceController::class, 'import']);
    });

// Group untuk API CityOrRegencies
Route::middleware('auth:api')
    ->prefix('city-or-regency')
    ->group(function () {
        Route::get('/', [CityOrRegencyController::class, 'index']);
        Route::post('/', [CityOrRegencyController::class, 'store']);
        Route::get('/{id}', [CityOrRegencyController::class, 'show']);
        Route::put('/{id}', [CityOrRegencyController::class, 'update']);
        Route::delete('/{id}', [CityOrRegencyController::class, 'destroy']);

        Route::get('/export-format', [CityOrRegencyController::class, 'exportFormat']);
        Route::get('/export', [CityOrRegencyController::class, 'export']);
        Route::post('/import', [CityOrRegencyController::class, 'import']);
    });

// Group untuk API Status
Route::middleware('auth:api')
    ->prefix('statuses')
    ->group(function () {
        Route::get('/', [StatusController::class, 'index']);
        Route::post('/', [StatusController::class, 'store']);
        Route::put('/{id}', [StatusController::class, 'update']);
        Route::delete('/{id}', [StatusController::class, 'destroy']);
    });

// Group untuk API Attendance
Route::middleware('auth:api')
    ->prefix('attendance')
    ->group(function () {
        Route::get('/', [AttendanceController::class, 'index']);
        Route::post('/', [AttendanceController::class, 'store']);
        Route::put('/{id}', [AttendanceController::class, 'update']);
        Route::delete('/{id}', [AttendanceController::class, 'destroy']);
    });
