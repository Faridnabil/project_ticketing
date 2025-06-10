<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VersiAPI\TicketHelpdeskApiController;
use App\Http\Controllers\VersiAPI\CaptchaController;


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

Route::get('province',[TicketHelpdeskApiController::class,'province']);
Route::get('kategori',[TicketHelpdeskApiController::class,'kategori']);
// Route::get('status',[TicketHelpdeskApiController::class,'status']);
Route::get('city',[TicketHelpdeskApiController::class,'city']);
Route::get('priority',[TicketHelpdeskApiController::class,'priority']);
Route::get('as',[TicketHelpdeskApiController::class,'get']);
Route::post('store',[TicketHelpdeskApiController::class,'store']);
Route::put('ticket/{no_ticket}', [TicketHelpdeskApiController::class,'update']);
Route::get('log/{no_ticket}', [TicketHelpdeskApiController::class,'logTicket']);

Route::get('regional',[TicketHelpdeskApiController::class,'regional']);
Route::get('prov/{regional_id}',[TicketHelpdeskApiController::class,'getProvince']);
Route::get('kab/{prov_id}',[TicketHelpdeskApiController::class,'getKabupaten']);
Route::get('kec/{kab_id}',[TicketHelpdeskApiController::class,'getKecamatan']);
Route::get('role',[TicketHelpdeskApiController::class,'role']);

Route::get('/reload-captcha', [CaptchaController::class, 'reloadCaptcha'])->name('reload.captcha');



