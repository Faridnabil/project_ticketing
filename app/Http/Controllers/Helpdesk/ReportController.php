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

        $req1 = $request->awal ?? null;
        $req2 = $request->akhir ?? null;
        $tickets = null;

        if ($req1 && $req2) {
            $startDate = Carbon::createFromFormat('Y-m-d', $req1)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $req2)->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);
            $tickets = $query->orderBy('id', 'asc')->get();
        }

        return view('dashboard.helpdesk.report.index', compact('tickets', 'categories', 'priorities', 'statuses', 'levels', 'req1', 'req2'));
    }


    // Fungsi bantuan untuk memproses filter tanggal
// Fungsi bantuan untuk memproses filter tanggal
private function getFilterDates(Request $request)
{
    $req1 = $request->awal ?? null;
    $req2 = $request->akhir ?? null;

    if ($req1 && $req2) {
        $startDate = Carbon::createFromFormat('Y-m-d', $req1)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $req2)->endOfDay();
    } else {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
    }

    return [$startDate, $endDate];
}

// Fungsi bantuan untuk query tiket berdasarkan filter
private function queryTickets(Request $request)
{
    [$startDate, $endDate] = $this->getFilterDates($request);

    $query = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
        ->whereBetween('created_at', [$startDate, $endDate]);

    // Tambahkan filter kategori
    if ($request->has('category_id') && $request->category_id) {
        $query->where('category_id', $request->category_id);
    }

    // Tambahkan filter prioritas
    if ($request->has('priority_id') && $request->priority_id) {
        $query->where('priority_id', $request->priority_id);
    }

    // Tambahkan filter status
    if ($request->has('status_id') && $request->status_id) {
        $query->where('status_id', $request->status_id);
    }

    // Tambahkan filter disposisi (misal level-level tertentu)
    if ($request->has('disposisi') && $request->disposisi) {
        $query->where(function ($q) use ($request) {
            $q->where('level1', $request->disposisi)
                ->orWhere('level2', $request->disposisi)
                ->orWhere('level3', $request->disposisi)
                ->orWhere('level4', $request->disposisi)
                ->orWhere('level5', $request->disposisi);
        });
    }

    return $query->orderBy('id', 'asc')->get();
}

// Fungsi Export Excel
public function export_ticket(Request $request)
{
    [$startDate, $endDate] = $this->getFilterDates($request);

    // Query tiket dengan semua filter
    $tickets = $this->queryTickets($request);

    // Format nama file berdasarkan tanggal dan filter
    $fileName = "Laporan_Tiket_{$startDate->format('d-m-Y')}-{$endDate->format('d-m-Y')}.xlsx";

    // Export data ke Excel
    return Excel::download(new ReportTicketExport($tickets), $fileName);
}

// Fungsi Export PDF
public function export_ticket_pdf(Request $request)
{
    [$startDate, $endDate] = $this->getFilterDates($request);

    // Query tiket dengan semua filter
    $tickets = $this->queryTickets($request);

    // Format nama file berdasarkan tanggal dan filter
    $fileName = "Laporan_Tiket_{$startDate->format('d-m-Y')}-{$endDate->format('d-m-Y')}.pdf";

    // Load view untuk PDF
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.helpdesk.report.pdf', [
        'tickets' => $tickets,
        'startDate' => $startDate,
        'endDate' => $endDate
    ]);

    return $pdf->download($fileName);
}

}
