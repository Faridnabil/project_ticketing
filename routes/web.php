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
use App\Http\Controllers\Koordinator\HomeKoordinatorController;
use App\Http\Controllers\Koordinator\TicketKoordinatorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Pejabat\HomePejabatController;
use App\Http\Controllers\Pejabat\TicketPejabatController;
use App\Http\Controllers\Helpdesk\ReportController;
use App\Http\Controllers\SiakDev\HomeSiakDevController;
use App\Http\Controllers\SiakDev\TicketSiakDevController;
use App\Http\Controllers\StaffSubdit\HomeStaffSubditController;
use App\Http\Controllers\StaffSubdit\TicketStaffSubditController;
use App\Http\Controllers\TeknisiHardware\DeviceAssetsController;
use App\Http\Controllers\TeknisiHardware\HomeTeknisiHardwareController;
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

Route::view('/error-403', 'errors.403')->name('error-403');
Route::view('/error-404', 'errors.404')->name('error-404');
Route::view('/error-500', 'errors.500')->name('error-500');


Route::get('/', function () {
    return redirect()->route('login'); // Mengarahkan ke halaman login
});

require __DIR__ . '/auth.php';

Route::middleware(['verified', 'auth', 'role:Admin|Helpdesk|Koordinator|Staff Subdit|SIAK Dev|Pejabat'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('profile/{id}/update_foto', [ProfileController::class, 'updateFoto'])->name('profile.update_foto');
});

//ADMIN, HELPDESK, KOORDINATOR, STAFF SUBDIT, SIAK DEV, PEJABAT
Route::middleware(['verified', 'auth', 'role:Admin|Helpdesk|Koordinator|Staff Subdit|SIAK Dev|Pejabat'])->group(function () {
    Route::resources([
        '/province' => ProvinceController::class,
        '/cityOrRegency' => CityOrRegencyController::class,
        '/priority' => PriorityController::class,
        '/status' => StatusController::class,
        '/category' => CategoryController::class,
    ]);

    Route::get('get-cities/{provinceId}', [TicketHelpdeskController::class, 'getCities']);

    Route::get('/province-export-format', [ProvinceController::class, 'exportFormat'])->name('province.exportFormat');
    Route::get('/province-export', [ProvinceController::class, 'export'])->name('province.export');
    Route::post('/province-import', [ProvinceController::class, 'import'])->name('province.import');

    Route::get('/city-or-regency-export-format', [CityOrRegencyController::class, 'exportFormat'])->name('cityOrRegency.exportFormat');
    Route::get('/city-or-regency-export', [CityOrRegencyController::class, 'export'])->name('cityOrRegency.export');
    Route::post('/city-or-regency-import', [CityOrRegencyController::class, 'import'])->name('cityOrRegency.import');
});

//ADMIN
Route::middleware(['verified', 'auth', 'role:Admin'])->name('admin.')->group(function () {
    Route::get('/admin/dashboard', [HomeAdminController::class, 'index'])->name('dashboard.index');
    Route::get('/admin/tickets/chart', [HomeAdminController::class, 'getTicketChartData']);
    Route::get('/admin/tickets/dailyChart', [HomeAdminController::class, 'getDailyTicketChartData']);
    Route::resources([
        '/admin/role' => RoleController::class,
        '/admin/permission' => PermissionController::class,
        '/admin/user' => UserController::class,
        '/admin/ticket' => TicketController::class,
    ]);


    Route::post('/admin/TicketStore', [TicketController::class, 'store_comment'])->name('tickets.store');
    Route::put('/admin/TicketUpdate/{id}', [TicketController::class, 'update_comment'])->name('tickets.update');

    Route::put('/admin/sendtTicket/{id}', [TicketController::class, 'send_ticket'])->name('tickets.send');
    Route::post('/admin/status-ticket/{id}', [TicketController::class, 'status_ticket'])->name('tickets.statusTicket');

    Route::get('/admin/approve-assignment', [RequestAssignmentController::class, 'index'])->name('requestAssignment.index');
    Route::post('/admin/approve-assignment/{requestAssignment}', [TicketController::class, 'approve_assignment'])->name('ticket.approveAssignment');
    Route::put('/ticket/{id}/update-approval', [RequestApprovalTicketController::class, 'update_ticket_approval'])->name('ticket.update_approval');
});

// HELPDESK
Route::middleware(['verified', 'auth', 'role:Helpdesk|Admin'])->name('helpdesk.')->group(function () {
    Route::get('/helpdesk/dashboard', [HomeHelpdeskController::class, 'index'])->name('dashboard.index');
    Route::get('/helpdesk/dashboardAll', [HomeHelpdeskController::class, 'indexAll'])->name('dashboard.indexAll');
    Route::get('/helpdesk/tickets/chart', [HomeHelpdeskController::class, 'getTicketChartData']);
    Route::get('/helpdesk/tickets/dailyChart', [HomeHelpdeskController::class, 'getDailyTicketChartData']);
    Route::get('/helpdesk/tickets/todaydailychart', [HomeHelpdeskController::class, 'todaygetTicketChartData'])->name('tickets.todaydailychart');
    Route::resources([
        '/helpdesk/ticket' => TicketHelpdeskController::class,
        '/helpdesk/attendance' => AttendanceHelpdeskController::class,
        // '/helpdesk/report' => ReportController::class,
    ]);
    Route::post('/helpdesk/TicketStore', [TicketHelpdeskController::class, 'store_comment'])->name('tickets.store');
    Route::put('/helpdesk/TicketUpdate/{id}', [TicketHelpdeskController::class, 'update_comment'])->name('tickets.update');
    Route::put('/helpdesk/sendTicket/{id}', [TicketHelpdeskController::class, 'send_ticket'])->name('tickets.send');

    Route::post('/helpdesk/status-ticket/{id}', [TicketHelpdeskController::class, 'status_ticket'])->name('tickets.statusTicket');

    Route::get('/helpdesk/newTicket', [TicketHelpdeskController::class, 'newTicket'])->name('newTickets.index');
    Route::get('/helpdesk/today', [TicketHelpdeskController::class, 'indexToday'])->name('tickets.indexToday');

    // Report Routes
    Route::get('/helpdesk/report', [ReportController::class, 'index'])->name('report.index');
    Route::post('/helpdesk/report/filter', [ReportController::class, 'index'])->name('report.filter');
    Route::get('/helpdesk/report/export', [ReportController::class, 'export_ticket'])->name('report.export');
    Route::get('/helpdesk/report/export-pdf', [ReportController::class, 'export_ticket_pdf'])->name('report.export_pdf');
    Route::get('helpdesk/report/preview_pdf', [ReportController::class, 'preview_ticket_pdf'])
    ->name('report.preview_pdf');

});


//KOORDINATOR
Route::middleware(['verified', 'auth', 'role:Koordinator'])->name('koordinator.')->group(function () {
    Route::get('/koordinator/dashboard', [HomeKoordinatorController::class, 'index'])->name('dashboard.index');
    Route::get('/koordinator/dashboardAll', [HomeKoordinatorController::class, 'indexAll'])->name('dashboard.indexAll');
    Route::get('/koordinator/tickets/chart', [HomeKoordinatorController::class, 'getTicketChartData']);
    Route::get('/koordinator/tickets/dailyChart', [HomeKoordinatorController::class, 'getDailyTicketChartData']);
    Route::get('/koordinator/tickets/todaydailychart', [HomekoordinatorController::class, 'todaygetTicketChartData'])->name('tickets.todaydailychart');

    Route::resources([
        '/koordinator/ticket' => TicketKoordinatorController::class,
    ]);
    Route::post('/koordinator/TicketStore', [TicketKoordinatorController::class, 'store_comment'])->name('tickets.store');
    Route::put('/koordinator/TicketUpdate/{id}', [TicketKoordinatorController::class, 'update_comment'])->name('tickets.update');

    Route::put('/koordinator/sendtTicket/{id}', [TicketKoordinatorController::class, 'send_ticket'])->name('tickets.send');
    Route::post('/koordinator/status-ticket/{id}', [TicketKoordinatorController::class, 'status_ticket'])->name('tickets.statusTicket');
});


//STAFF SUBDIT
Route::middleware(['verified', 'auth', 'role:Staff Subdit'])->name('staffSubdit.')->group(function () {
    Route::get('/staff-subdit/dashboard', [HomeStaffSubditController::class, 'index'])->name('dashboard.index');
    Route::get('/staff-subdit/dashboardAll', [HomeStaffSubditController::class, 'indexAll'])->name('dashboard.indexAll');
    Route::get('/staff-subdit/tickets/chart', [HomeStaffSubditController::class, 'getTicketChartData']);
    Route::get('/staff-subdit/tickets/dailyChart', [HomeStaffSubditController::class, 'getDailyTicketChartData']);
    Route::get('/staff-subdit/tickets/todaydailychart', [HomeStaffSubditController::class, 'todaygetTicketChartData'])->name('tickets.todaydailychart');


    Route::resources([
        '/staff-subdit/ticket' => TicketStaffSubditController::class,
    ]);
    Route::post('/staff-subdit/TicketStore', [TicketStaffSubditController::class, 'store_comment'])->name('tickets.store');
    Route::put('/staff-subdit/TicketUpdate/{id}', [TicketStaffSubditController::class, 'update_comment'])->name('tickets.update');
    Route::put('/staff-subdit/sendtTicket/{id}', [TicketStaffSubditController::class, 'send_ticket'])->name('tickets.send');
    Route::post('/staff-subdit/status-ticket/{id}', [TicketStaffSubditController::class, 'status_ticket'])->name('tickets.statusTicket');
});


//SIAK DEV
Route::middleware(['verified', 'auth', 'role:SIAK Dev'])->name('siakDev.')->group(function () {
    Route::get('/siak-dev/dashboard', [HomeSiakDevController::class, 'index'])->name('dashboard.index');
    Route::get('/siak-dev/dashboardAll', [HomeSiakDevController::class, 'indexAll'])->name('dashboard.indexAll');
    Route::get('/siak-dev/tickets/chart', [HomeSiakDevController::class, 'getTicketChartData']);
    Route::get('/siak-dev/tickets/dailyChart', [HomeSiakDevController::class, 'getDailyTicketChartData']);
    Route::get('/siak-dev/tickets/todaydailychart', [HomeSiakDevController::class, 'todaygetTicketChartData'])->name('tickets.todaydailychart');

    Route::resources([
        '/siak-dev/ticket' => TicketSiakDevController::class,
    ]);
    Route::post('/siak-dev/TicketStore', [TicketSiakDevController::class, 'store_comment'])->name('tickets.store');
    Route::put('/siak-dev/TicketUpdate/{id}', [TicketSiakDevController::class, 'update_comment'])->name('tickets.update');
    Route::put('/siak-dev/sendtTicket/{id}', [TicketSiakDevController::class, 'send_ticket'])->name('tickets.send');
    Route::post('/siak-dev/status-ticket/{id}', [TicketSiakDevController::class, 'status_ticket'])->name('tickets.statusTicket');
});


//PEJABAT
Route::middleware(['verified', 'auth', 'role:Pejabat'])->name('pejabat.')->group(function () {
    Route::get('/pejabat/dashboard', [HomePejabatController::class, 'index'])->name('dashboard.index');
    Route::get('/pejabat/dashboardAll', [HomePejabatController::class, 'indexAll'])->name('dashboard.indexAll');
    Route::get('/pejabat/tickets/chart', [HomePejabatController::class, 'getTicketChartData']);
    Route::get('/pejabat/tickets/dailyChart', [HomePejabatController::class, 'getDailyTicketChartData']);
    Route::get('/pejabat/tickets/todaydailychart', [HomePejabatController::class, 'todaygetTicketChartData'])->name('tickets.todaydailychart');

    Route::resources([
        '/pejabat/ticket' => TicketPejabatController::class,
    ]);
    Route::post('/pejabat/TicketStore', [TicketPejabatController::class, 'store_comment'])->name('tickets.store');
    Route::put('/pejabat/TicketUpdate/{id}', [TicketPejabatController::class, 'update_comment'])->name('tickets.update');
    Route::put('/pejabat/sendtTicket/{id}', [TicketPejabatController::class, 'send_ticket'])->name('tickets.send');
    Route::post('/pejabat/status-ticket/{id}', [TicketPejabatController::class, 'status_ticket'])->name('tickets.statusTicket');
});

//TEKNISI HARDWARE
Route::middleware(['verified', 'auth', 'role:Teknisi Hardware'])->name('teknisiHardware.')->group(function () {
    Route::get('/teknisi-hardware/dashboard', [HomeTeknisiHardwareController::class, 'index'])->name('dashboard.index');
    Route::get('/teknisi-hardware/tickets/chart', [HomeTeknisiHardwareController::class, 'getTicketChartData']);
    Route::get('/teknisi-hardware/tickets/dailyChart', [HomeTeknisiHardwareController::class, 'getDailyTicketChartData']);
    Route::resources([
        '/teknisi-hardware/deviceAssets' => DeviceAssetsController::class,
    ]);
});
