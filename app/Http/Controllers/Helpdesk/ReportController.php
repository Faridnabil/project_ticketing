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

        // Retrieve filter inputs
        $req1 = $request->awal ?? null;
        $req2 = $request->akhir ?? null;

        // Apply filters if any filter inputs are present
        if ($req1 && $req2) {
            $startDate = Carbon::createFromFormat('Y-m-d', $req1)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $req2)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('level') && $request->level) {
            $query->where(function ($q) use ($request) {
                $q->where('level1', $request->level)
                    ->orWhere('level2', $request->level)
                    ->orWhere('level3', $request->level)
                    ->orWhere('level4', $request->level)
                    ->orWhere('level5', $request->level);
            });
        }

        if ($request->has('priority_id') && $request->priority_id) {
            $query->where('priority_id', $request->priority_id);
        }

        if ($request->has('status_id') && $request->status_id) {
            $query->where('status_id', $request->status_id);
        }

        // Get tickets only if any filters are applied
        $tickets = null;
        if ($req1 || $req2 || $request->category_id || $request->level || $request->priority_id || $request->status_id) {
            $tickets = $query->orderBy('id', 'desc')->get();
        }

        // Retrieve filter data
        $categories = Category::all();
        $levels = Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get();
        $priorities = Priority::all();
        $statuses = Status::all();

        return view('dashboard.helpdesk.report.index', compact('tickets', 'categories', 'priorities', 'statuses', 'levels', 'req1', 'req2'));
    }


    public function export_ticket(Request $request)
    {
        // Mengambil nilai dari request yang difilter
        $req1 = $request->awal ?? null;
        $req2 = $request->akhir ?? null;

        // Validasi jika request ada, jika tidak ambil tanggal sekarang
        if ($req1 && $req2) {
            $startDate = Carbon::createFromFormat('Y-m-d', $req1)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $req2)->endOfDay();
        } else {
            // Jika tidak ada filter tanggal, gunakan tanggal default (misal hari ini)
            $startDate = Carbon::now()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        }

        // Query tiket dengan filter tanggal
        $query = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
                       ->whereBetween('created_at', [$startDate, $endDate]);

        // Urutkan data secara ascending
        $tickets = $query->orderBy('id', 'asc')->get();

        // Format nama file berdasarkan tanggal awal dan akhir yang difilter
        $startDateFormatted = $startDate->format('d-m-Y');
        $endDateFormatted = $endDate->format('d-m-Y');
        $fileName = "Laporan_Tiket_{$startDateFormatted}-{$endDateFormatted}.xlsx";

        // Export file Excel dengan nama yang sudah diformat
        return Excel::download(new ReportTicketExport($tickets), $fileName);
    }



}
