<?php

namespace App\Http\Controllers\Helpdesk;


use App\Exports\ReportTicketExport;
use App\Exports\ReportNotedTicketExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $req1 = $request->awal ?? null;
        $req2 = $request->akhir ?? null;

        // Generate unique cache key based on filters
        $cacheKey = 'tickets_report_' . md5(json_encode([
            'awal' => $req1,
            'akhir' => $req2,
            'category_id' => $request->category_id,
            'level' => $request->level,
            'priority_id' => $request->priority_id,
            'status_id' => $request->status_id,
        ]));

        $tickets = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($req1, $req2, $request) {
            $query = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat');

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

            return $query->orderBy('id', 'desc')->get();
        });

        // Cache reference data (optional but recommended)
        $categories = Cache::remember('categories', now()->addHours(1), fn () => Category::all());
        $priorities = Cache::remember('priorities', now()->addHours(1), fn () => Priority::all());
        $statuses = Cache::remember('statuses', now()->addHours(1), fn () => Status::all());
        $levels = Cache::remember('levels', now()->addHours(1), fn () => Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get());

        return view('dashboard.helpdesk.report.index', compact('tickets', 'categories', 'priorities', 'statuses', 'levels', 'req1', 'req2'));
    }


    private function getFilterDates(Request $request)
    {
        $req1 = $request->awal;
        $req2 = $request->akhir;

        if ($req1 && $req2) {
            $startDate = Carbon::createFromFormat('Y-m-d', $req1)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $req2)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        }

        return [$startDate, $endDate];
    }


    private function queryTickets(Request $request)
    {
        [$startDate, $endDate] = $this->getFilterDates($request);

        // Buat cache key unik berdasarkan filter request
        $cacheKey = 'query_tickets_' . md5(json_encode([
            'start'       => $startDate->toDateTimeString(),
            'end'         => $endDate->toDateTimeString(),
            'category_id' => $request->input('category_id'),
            'priority_id' => $request->input('priority_id'),
            'status_id'   => $request->input('status_id'),
            'level'       => $request->input('level'),
        ]));

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request, $startDate, $endDate) {
            $query = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
                ->whereBetween('created_at', [$startDate, $endDate]);

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->filled('priority_id')) {
                $query->where('priority_id', $request->priority_id);
            }

            if ($request->filled('status_id')) {
                $query->where('status_id', $request->status_id);
            }

            if ($request->filled('level')) {
                $query->where(function ($q) use ($request) {
                    $q->where('level1', $request->level)
                        ->orWhere('level2', $request->level)
                        ->orWhere('level3', $request->level)
                        ->orWhere('level4', $request->level)
                        ->orWhere('level5', $request->level);
                });
            }

            return $query->orderBy('id', 'asc')->get();
        });
    }


    // Fungsi Export Excel
    public function export_ticket(Request $request)
    {
        // Ambil data tiket yang sudah difilter
        $tickets = $this->queryTickets($request);

        [$startDate, $endDate] = $this->getFilterDates($request);

        // Format nama file berdasarkan tanggal
        $fileName = "Laporan_Tiket_{$startDate->format('d-m-Y')}_{$endDate->format('d-m-Y')}.xlsx";

        // Export ke Excel
        return Excel::download(new ReportTicketExport($tickets), $fileName);
    }
    public function export_noted_ticket(Request $request)
    {
        // Ambil data tiket berdasarkan kondisi yang diberikan
        $tickets = Ticket::with([
            'status',
            'category',
            'priority',
            'helpdesk',
            'koordinator',
            'staffSubdit',
            'siakDev',
            'pejabat'
        ])
            ->whereNotNull('completion_notes')
            ->where('completion_notes', '!=', '')
            ->get();

        // Format nama file berdasarkan tanggal saat ini
        $fileName = "Laporan_Tiket_" . now()->format('d-m-Y') . ".xlsx";

        // Export ke Excel
        return Excel::download(new ReportNotedTicketExport($tickets), $fileName);
    }


    // Fungsi Export PDF
    public function export_ticket_pdf(Request $request)
    {
        $tickets = $this->queryTickets($request);

        [$startDate, $endDate] = $this->getFilterDates($request);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.helpdesk.report.pdf', [
            'tickets' => $tickets,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);

        $fileName = "Laporan_Tiket_{$startDate->format('d-m-Y')}_{$endDate->format('d-m-Y')}.pdf";

        return $pdf->download($fileName);
    }

    public function preview_ticket_pdf(Request $request)
    {
        $tickets = $this->queryTickets($request);
        [$startDate, $endDate] = $this->getFilterDates($request);

        return view('dashboard.helpdesk.report.pdf-view', [
            'tickets' => $tickets,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

}
