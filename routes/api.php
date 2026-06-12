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
    Route::get('/tickets-by-province', [DashboardController::class, 'getTicketsByProvince']);
    Route::get('/tickets-by-city', [DashboardController::class, 'getTicketsByCity']);
    Route::get('/progress-tickets-by-province', [DashboardController::class, 'getTopUncompletedTicketsByProvince']);
    Route::get('/progress-tickets-by-city', [DashboardController::class, 'getTopUncompletedTicketsByCity']);
    Route::get('/tickets/today', [DashboardController::class, 'getTodayTickets']);
});
