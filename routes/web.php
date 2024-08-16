<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\PriorityController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RequestAssignmentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Sysadmin\UnassignedSysadminController;
use App\Http\Controllers\User\HomeUserController;
use App\Http\Controllers\User\TicketUserController;

use App\Http\Controllers\Dba\HomeDbaController;
use App\Http\Controllers\Dba\AssignedTicketController;
use App\Http\Controllers\Dba\UnassignedTicketController;
use App\Http\Controllers\Dba\IncidentalActivityController;

use App\Http\Controllers\Admin\IncidentalActivityCategoryController;
use App\Http\Controllers\Dba\AssignedDbaController;
use App\Http\Controllers\Dba\IncidentalDbaController;
use App\Http\Controllers\Dba\UnassignedDbaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Sysadmin\AssignedSysadminController;
use App\Http\Controllers\Sysadmin\HomeSysadminController;
use App\Http\Controllers\Sysadmin\IncidentalSysadminController;
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

//Notifikasi
Route::get('/notification', [NotificationController::class, 'sendnotification']);
Route::patch('/notifications/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');


Route::get('/', function () {
    return redirect()->route('login'); // Mengarahkan ke halaman login
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('profile/{id}/update_foto', [ProfileController::class, 'updateFoto'])->name('profile.update_foto');
});

require __DIR__ . '/auth.php';



Route::middleware(['verified', 'auth', 'role:Super Admin|Admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeAdminController::class, 'index'])->name('admin.dashboard.index');
    Route::get('/admin/tickets/chart', [HomeAdminController::class, 'getTicketChartData']);


    Route::resources([
        '/admin/role' => RoleController::class,
        '/admin/permission' => PermissionController::class,
        '/admin/user' => UserController::class,
        '/admin/ticket' => TicketController::class,
    ]);

    Route::post('/admin/TicketStore', [TicketController::class, 'store_comment'])->name('tickets.store');
    Route::put('/admin/TicketUpdate/{id}', [TicketController::class, 'update_comment'])->name('tickets.update');
    Route::get('/ticket/export', [TicketController::class, 'export'])->name('ticket.export');

    Route::get('/approve-assignment', [RequestAssignmentController::class, 'index'])->name('requestAssignment.index');
    Route::post('/approve-assignment/{requestAssignment}', [TicketController::class, 'approve_assignment'])->name('ticket.approveAssignment');
});

Route::middleware(['verified', 'auth', 'role:Super Admin|Admin|SysAdmin|DBA'])->group(function () {
    Route::get('/admin/dashboard', [HomeAdminController::class, 'index'])->name('admin.dashboard.index');

    Route::resources([
        '/admin/priority' => PriorityController::class,
        '/admin/status' => StatusController::class,
        '/admin/category' => CategoryController::class,
        '/admin/incidental-activity-category' => IncidentalActivityCategoryController::class,
    ]);
});

Route::middleware(['verified', 'auth', 'role:User'])->group(function () {
    Route::get('/users/dashboard', [HomeUserController::class, 'index'])->name('user.dashboard.index');

    Route::resources([
        '/users/myTicket' => TicketUserController::class,
    ]);
    Route::get('/users/completed-tickets', [TicketUserController::class, 'completedTickets'])->name('myTicket.completed');
    Route::post('/users/TicketStore', [TicketUserController::class, 'store_comment'])->name('myTickets.store');
    Route::put('/users/TicketUpdate/{id}', [TicketUserController::class, 'update_comment'])->name('myTickets.update');
});

//SysAdmin
Route::middleware(['verified', 'auth', 'role:SysAdmin'])->group(function () {
    Route::get('/sysadmin/dashboard', [HomeSysadminController::class, 'index'])->name('sysadmin.dashboard.index');

    Route::resources([
        '/sysadmin/assignedSysadmin' => AssignedSysadminController::class,
    ]);
    Route::get('/sysadmin/unassignedTicket', [UnassignedSysadminController::class, 'index'])->name('unassignedSysadmin.index');
    Route::get('/sysadmin/unassignedTicketShow/{id}', [UnassignedSysadminController::class, 'show'])->name('unassignedSyasadmin.show');

    Route::post('/sysadmin/unassignedTicketStore', [UnassignedSysadminController::class, 'store_comment'])->name('sysadmin.unassignedTickets.store');
    Route::put('/sysadmin/unassignedTicketUpdate/{id}', [UnassignedSysadminController::class, 'update_comment'])->name('unassignedTickets.update');

    Route::post('/sysadmin/assignedTicketStore', [AssignedSysadminController::class, 'store_comment'])->name('sysadmin.assignedTickets.store');
    Route::put('/sysadmin/assignedTicketUpdate/{id}', [AssignedSysadminController::class, 'update_comment'])->name('sysadmin.assignedTickets.update');
    Route::get('/sysadmin/completed-tickets', [AssignedSysadminController::class, 'completedTickets'])->name('sysadmin.completed-tickets');
    Route::get('/sysadmin/export-tickets', [AssignedSysadminController::class, 'export'])->name('sysadmin.tickets.export');

    Route::get('/sysadmin/incidental-activities', [IncidentalSysadminController::class, 'index'])->name('sysadmin.incidental-activities.index');
    Route::get('/sysadmin/incidental-activities/create', [IncidentalSysadminController::class, 'create'])->name('sysadmin.incidental-activities.create');
    Route::post('/sysadmin/incidental-activities', [IncidentalSysadminController::class, 'store'])->name('sysadmin.incidental-activities.store');
    Route::get('/sysadmin/incidental-activities/{id}/edit', [IncidentalSysadminController::class, 'edit'])->name('sysadmin.incidental-activities.edit');
    Route::put('/sysadmin/incidental-activities/{id}', [IncidentalSysadminController::class, 'update'])->name('sysadmin.incidental-activities.update');
    Route::delete('/sysadmin/incidental-activities/{id}', [IncidentalSysadminController::class, 'destroy'])->name('sysadmin.incidental-activities.destroy');


    Route::post('/sysadmin/request-assignment/{ticket}', [UnassignedSysadminController::class, 'request_assignment'])->name('sysadmin.unassignedTicket.requestAssignment');
});

Route::middleware(['verified', 'auth', 'role:DBA'])->group(function () {
    Route::get('/dba/dashboard', [HomeDBAController::class, 'index'])->name('dba.dashboard.index');

    Route::resources([
        '/dba/assignedDba' => AssignedDbaController::class,
    ]);


    Route::get('/dba/unassignedTicket', [UnassignedDbaController::class, 'index'])->name('unassignedDba.index');
    Route::get('/dba/unassignedTicketShow/{id}', [UnassignedDbaController::class, 'show'])->name('unassignedDba.show');

    Route::post('/dba/unassignedTicketStore', [UnassignedDbaController::class, 'store_comment'])->name('dba.unassignedTickets.store');
    Route::put('/dba/unassignedTicketUpdate/{id}', [UnassignedDbaController::class, 'update_comment'])->name('unassignedTickets.update');

    Route::post('/dba/assignedTicketStore', [AssignedDbaController::class, 'store_comment'])->name('assignedTickets.store');
    Route::put('/dba/assignedTicketUpdate/{id}', [AssignedDbaController::class, 'update_comment'])->name('assignedTickets.update');
    Route::get('/dba/completed-tickets', [AssignedDbaController::class, 'completedTickets'])->name('dba.completed-tickets');
    Route::get('/dba/export-tickets', [AssignedDbaController::class, 'export'])->name('dba.tickets.export');

    // Route
    Route::get('/dba/incidental-activities', [IncidentalDbaController::class, 'index'])->name('dba.incidental-activities.index');
    Route::get('/dba/incidental-activities/create', [IncidentalDbaController::class, 'create'])->name('dba.incidental-activities.create');
    Route::post('/dba/incidental-activities', [IncidentalDbaController::class, 'store'])->name('dba.incidental-activities.store');
    Route::get('/dba/incidental-activities/{id}/edit', [IncidentalDbaController::class, 'edit'])->name('dba.incidental-activities.edit');
    Route::put('/dba/incidental-activities/{id}', [IncidentalDbaController::class, 'update'])->name('dba.incidental-activities.update');
    Route::delete('/dba/incidental-activities/{id}', [IncidentalDbaController::class, 'destroy'])->name('dba.incidental-activities.destroy');


    Route::post('/dba/request-assignment/{ticket}', [UnassignedDbaController::class, 'request_assignment'])->name('dba.unassignedTicket.requestAssignment');
});
