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
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat');

        $categories = Category::all();
        $levels = Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get();
        $priorities = Priority::all();
        $statuses = Status::all();

        $req1 = $request->awal ?? null;
        $req2 = $request->akhir ?? null;
        $tickets = null;

        if ($req1 && $req2) {
            $startDate = Carbon::createFromFormat('Y-m-d', $req1)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $req2)->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);
            $tickets = $query->orderBy('id', 'desc')->get();
        }

        return view('dashboard.helpdesk.report.index', compact('tickets', 'categories', 'priorities', 'statuses', 'levels', 'req1', 'req2'));
    }
    public function export_ticket(Request $request)
    {
        $query = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat');

        $req1 = $request->awal ?? null;
        $req2 = $request->akhir ?? null;

        if ($req1 && $req2) {
            $startDate = Carbon::createFromFormat('Y-m-d', $req1)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $req2)->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $tickets = $query->orderBy('id', 'desc')->get();

        return Excel::download(new ReportTicketExport($tickets), 'Laporan_Tiket.xlsx');
    }

}
