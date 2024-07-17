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
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\CityOrRegencyController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\RequestApprovalTicketController;
use App\Http\Controllers\Customer\HomeCustomerController;
use App\Http\Controllers\Customer\TicketCustomerController;
use App\Http\Controllers\Department\AssignedTicketController;
use App\Http\Controllers\Department\HomeDepartmentController;
use App\Http\Controllers\Department\RequestTicketController;
use App\Http\Controllers\Department\UnassignedTicketController;
use App\Http\Controllers\NotificationController;
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

require __DIR__ . '/auth.php';

Route::middleware(['verified', 'auth', 'role:Super Admin|Admin|Customer|Department'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('profile/{id}/update_foto', [ProfileController::class, 'updateFoto'])->name('profile.update_foto');
});

Route::middleware(['verified', 'auth', 'role:Super Admin|Admin|Department'])->group(function () {
    Route::get('/admin/dashboard', [HomeAdminController::class, 'index'])->name('admin.dashboard.index');

    Route::resources([
        '/admin/priority' => PriorityController::class,
        '/admin/status' => StatusController::class,
        '/admin/category' => CategoryController::class,
    ]);
});


//ADMIN
Route::middleware(['verified', 'auth', 'role:Super Admin|Admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeAdminController::class, 'index'])->name('admin.dashboard.index');
    Route::get('/admin/tickets/chart', [HomeAdminController::class, 'getTicketChartData']);


    Route::resources([
        '/admin/role' => RoleController::class,
        '/admin/permission' => PermissionController::class,
        '/admin/user' => UserController::class,
        '/admin/ticket' => TicketController::class,
        '/admin/attendance' => AttendanceController::class,
        '/admin/province' => ProvinceController::class,
        '/admin/cityOrRegency' => CityOrRegencyController::class,
    ]);

    Route::post('/admin/TicketStore', [TicketController::class, 'store_comment'])->name('tickets.store');
    Route::put('/admin/TicketUpdate/{id}', [TicketController::class, 'update_comment'])->name('tickets.update');

    Route::get('/admin/approve-assignment', [RequestAssignmentController::class, 'index'])->name('requestAssignment.index');
    Route::post('/admin/approve-assignment/{requestAssignment}', [TicketController::class, 'approve_assignment'])->name('ticket.approveAssignment');
    Route::put('/ticket/{id}/update-approval', [RequestApprovalTicketController::class, 'update_ticket_approval'])->name('ticket.update_approval');
});


//CUSTOMER
Route::middleware(['verified', 'auth', 'role:Customer'])->group(function () {
    Route::get('/customer/dashboard', [HomeCustomerController::class, 'index'])->name('customer.dashboard.index');

    Route::resources([
        '/customer/myTicket' => TicketCustomerController::class,
    ]);

    Route::post('/customer/TicketStore', [TicketCustomerController::class, 'store_comment'])->name('myTickets.store');
    Route::put('/customer/TicketUpdate/{id}', [TicketCustomerController::class, 'update_comment'])->name('myTickets.update');
});


//DEPARTMENT
Route::middleware(['verified', 'auth', 'role:Department'])->group(function () {
    Route::get('/department/dashboard', [HomeDepartmentController::class, 'index'])->name('department.dashboard.index');

    Route::resources([
        '/department/assignedTicket' => AssignedTicketController::class,
    ]);

    Route::get('/department/unassignedTicket', [UnassignedTicketController::class, 'index'])->name('unassignedTicket.index');
    Route::get('/department/unassignedTicketShow/{id}', [UnassignedTicketController::class, 'show'])->name('unassignedTicket.show');

    Route::post('/department/unassignedTicketStore', [UnassignedTicketController::class, 'store_comment'])->name('unassignedTickets.store');
    Route::put('/department/unassignedTicketUpdate/{id}', [UnassignedTicketController::class, 'update_comment'])->name('unassignedTickets.update');

    Route::post('/department/request-assignment/{ticket}', [UnassignedTicketController::class, 'request_assignment'])->name('unassignedTicket.requestAssignment');

    Route::post('/department/assignedTicketStore', [AssignedTicketController::class, 'store_comment'])->name('assignedTickets.store');
    Route::put('/department/assignedTicketUpdate/{id}', [AssignedTicketController::class, 'update_comment'])->name('assignedTickets.update');

    Route::put('/department/request-assignTo/{id}', [RequestTicketController::class, 'request_ticket'])->name('requestTicket.requestAssignTo');
    Route::get('/department/requestTicket', [RequestTicketController::class, 'index'])->name('requestTicket.index');
    Route::post('/department/approve-ticket/{id}', [RequestTicketController::class, 'approve_ticket'])->name('requestTicket.approveTicket');
    Route::post('/department/reject-ticket/{id}', [RequestTicketController::class, 'reject_ticket'])->name('requestTicket.rejectTicket');

    Route::post('/department/send-ticket/{id}', [RequestTicketController::class, 'send_ticket'])->name('requestTicket.sendTicket');
    Route::post('/department/status-ticket/{id}', [RequestTicketController::class, 'status_ticket'])->name('requestTicket.statusTicket');

});
