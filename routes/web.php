<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PriorityController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('profile/{id}/update_foto', [ProfileController::class, 'updateFoto'])->name('profile.update_foto');
});

require __DIR__ . '/auth.php';

Route::middleware(['verified', 'auth', 'role:Super Admin|Admin|Department|Customer'])->group(function () {

    Route::resources([
        '/role'                                     => RoleController::class,
        '/permission'                               => PermissionController::class,
        '/user'                                     => UserController::class,
        '/ticket'                                   => TicketController::class,
        '/priority'                                 => PriorityController::class,
        '/status'                                   => StatusController::class,
        '/category'                                 => CategoryController::class,
    ]);
});
