<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('dashboard')->group(function () {
    Route::get('/summary', [DashboardController::class, 'getSummary']);
    Route::get('/chart/monthly', [DashboardController::class, 'getMonthlyChart']);
    Route::get('/chart/daily', [DashboardController::class, 'getDailyChart']);
    Route::get('/problems', [DashboardController::class, 'getProblemReport']);
});
