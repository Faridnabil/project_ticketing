<?php

namespace App\Http\Controllers\Helpdesk;

use App\Exports\ReportTicketExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with('status', 'category', 'priority', 'helpdesk');

        $categories = Category::all();
        $levels = Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get();
        $priorities = Priority::all();
        $statuses = Status::all();

        $req1 = $request->awal ?? null;
        $req2 = $request->akhir ?? null;
        $tickets = null;

        if ($req1 && $req2) {
            $query->whereBetween('created_at', [$req1, $req2]);
            $tickets = $query->orderBy('id', 'desc')->get();
        }

        return view('dashboard.helpdesk.report.index', compact('tickets', 'categories', 'priorities', 'statuses', 'levels', 'req1', 'req2'));
    }

    public function export_ticket(Request $request)
    {
        $tickets = Ticket::whereBetween('created_at', [$request->awal, $request->akhir])->get();
        return Excel::download(new ReportTicketExport($tickets), 'Laporan_Tiket.xlsx');
    }

    public function show(Request $request)
{
    $query = Ticket::with('status', 'category', 'priority', 'helpdesk');

    $categories = Category::all();
    $levels = Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get();
    $priorities = Priority::all();
    $statuses = Status::all();

    $req1 = $request->awal ?? null;
    $req2 = $request->akhir ?? null;
    $tickets = null;

    if ($req1 && $req2) {
        $query->whereBetween('created_at', [$req1, $req2]);
        $tickets = $query->orderBy('id', 'desc')->get();
    }

    return view('dashboard.helpdesk.report.index', compact('tickets', 'categories', 'priorities', 'statuses', 'levels', 'req1', 'req2'));
}

}
