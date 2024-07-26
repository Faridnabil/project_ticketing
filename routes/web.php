<?php

use App\Http\Controllers\Helpdesk\TicketHelpdeskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\CityOrRegencyController;
use App\Http\Controllers\ProvinceController;

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\RequestAssignmentController;
use App\Http\Controllers\Admin\RequestApprovalTicketController;

use App\Http\Controllers\Helpdesk\AttendanceHelpdeskController;
use App\Http\Controllers\Helpdesk\HomeHelpdeskController;

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

Route::middleware(['verified', 'auth', 'role:Helpdesk|Admin|Customer|Department'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('profile/{id}/update_foto', [ProfileController::class, 'updateFoto'])->name('profile.update_foto');
});

//ADMIN
Route::middleware(['verified', 'auth', 'role:Admin'])->name('admin.')->group(function () {
    Route::get('/admin/dashboard', [HomeAdminController::class, 'index'])->name('dashboard.index');
    Route::get('/admin/tickets/chart', [HomeAdminController::class, 'getTicketChartData']);
    Route::resources([
        '/admin/role' => RoleController::class,
        '/admin/permission' => PermissionController::class,
        '/admin/user' => UserController::class,
        '/admin/ticket' => TicketController::class,
    ]);


    Route::post('/admin/TicketStore', [TicketController::class, 'store_comment'])->name('tickets.store');
    Route::put('/admin/TicketUpdate/{id}', [TicketController::class, 'update_comment'])->name('tickets.update');

    Route::get('/admin/approve-assignment', [RequestAssignmentController::class, 'index'])->name('requestAssignment.index');
    Route::post('/admin/approve-assignment/{requestAssignment}', [TicketController::class, 'approve_assignment'])->name('ticket.approveAssignment');
    Route::put('/ticket/{id}/update-approval', [RequestApprovalTicketController::class, 'update_ticket_approval'])->name('ticket.update_approval');
});


//HELPDESK
Route::middleware(['verified', 'auth', 'role:Helpdesk'])->name('helpdesk.')->group(function () {
    Route::get('/helpdesk/dashboard', [HomeHelpdeskController::class, 'index'])->name('dashboard.index');
    Route::get('/helpdesk/tickets/chart', [HomeHelpdeskController::class, 'getTicketChartData']);
    Route::get('/helpdesk/tickets/dailyChart', [HomeHelpdeskController::class, 'getDailyTicketChartData']);
    Route::resources([
        '/helpdesk/ticket' => TicketHelpdeskController::class,
        '/helpdesk/attendance' => AttendanceHelpdeskController::class,
    ]);
    Route::post('/helpdesk/TicketStore', [TicketHelpdeskController::class, 'store_comment'])->name('tickets.store');
    Route::put('/helpdesk/TicketUpdate/{id}', [TicketHelpdeskController::class, 'update_comment'])->name('tickets.update');

    Route::get('/get-cities/{provinceId}', [TicketHelpdeskController::class, 'getCities']);
    Route::post('/helpdesk/status-ticket/{id}', [TicketHelpdeskController::class, 'status_ticket'])->name('tickets.statusTicket');
});

//ADMIN, HELPDESK
Route::middleware(['verified', 'auth', 'role:Admin|Helpdesk'])->group(function () {
    Route::resources([
        '/province' => ProvinceController::class,
        '/cityOrRegency' => CityOrRegencyController::class,
        '/priority' => PriorityController::class,
        '/status' => StatusController::class,
        '/category' => CategoryController::class,
    ]);

    Route::get('/province-export-format', [ProvinceController::class, 'exportFormat'])->name('province.exportFormat');
    Route::get('/province-export', [ProvinceController::class, 'export'])->name('province.export');
    Route::post('/province-import', [ProvinceController::class, 'import'])->name('province.import');

    Route::get('/city-or-regency-export-format', [CityOrRegencyController::class, 'exportFormat'])->name('cityOrRegency.exportFormat');
    Route::get('/city-or-regency-export', [CityOrRegencyController::class, 'export'])->name('cityOrRegency.export');
    Route::post('/city-or-regency-import', [CityOrRegencyController::class, 'import'])->name('cityOrRegency.import');
});



//CUSTOMER
// Route::middleware(['verified', 'auth', 'role:Customer'])->group(function () {
//     Route::get('/customer/dashboard', [HomeCustomerController::class, 'index'])->name('customer.dashboard.index');

//     Route::resources([
//         '/customer/myTicket' => TicketCustomerController::class,
//     ]);

//     Route::post('/customer/TicketStore', [TicketCustomerController::class, 'store_comment'])->name('myTickets.store');
//     Route::put('/customer/TicketUpdate/{id}', [TicketCustomerController::class, 'update_comment'])->name('myTickets.update');
// });


//DEPARTMENT
// Route::middleware(['verified', 'auth', 'role:Department'])->group(function () {
//     Route::get('/department/dashboard', [HomeDepartmentController::class, 'index'])->name('department.dashboard.index');

//     Route::resources([
//         '/department/assignedTicket' => AssignedTicketController::class,
//     ]);

//     Route::get('/department/unassignedTicket', [UnassignedTicketController::class, 'index'])->name('unassignedTicket.index');
//     Route::get('/department/unassignedTicketShow/{id}', [UnassignedTicketController::class, 'show'])->name('unassignedTicket.show');

//     Route::post('/department/unassignedTicketStore', [UnassignedTicketController::class, 'store_comment'])->name('unassignedTickets.store');
//     Route::put('/department/unassignedTicketUpdate/{id}', [UnassignedTicketController::class, 'update_comment'])->name('unassignedTickets.update');

//     Route::post('/department/request-assignment/{ticket}', [UnassignedTicketController::class, 'request_assignment'])->name('unassignedTicket.requestAssignment');

//     Route::post('/department/assignedTicketStore', [AssignedTicketController::class, 'store_comment'])->name('assignedTickets.store');
//     Route::put('/department/assignedTicketUpdate/{id}', [AssignedTicketController::class, 'update_comment'])->name('assignedTickets.update');

//     Route::put('/department/request-assignTo/{id}', [RequestTicketController::class, 'request_ticket'])->name('requestTicket.requestAssignTo');
//     Route::get('/department/requestTicket', [RequestTicketController::class, 'index'])->name('requestTicket.index');
//     Route::post('/department/approve-ticket/{id}', [RequestTicketController::class, 'approve_ticket'])->name('requestTicket.approveTicket');
//     Route::post('/department/reject-ticket/{id}', [RequestTicketController::class, 'reject_ticket'])->name('requestTicket.rejectTicket');

//     Route::post('/department/status-ticket/{id}', [RequestTicketController::class, 'status_ticket'])->name('requestTicket.statusTicket');

// });
