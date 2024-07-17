<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\HistoryTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeAdminController extends Controller
{
    public function index(Request $request)
{
    $selectedTicketId = $request->input('ticket_number');
    $selectedTicketNumber = null;

    // Mengambil semua tiket
    $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo')->get();
    $logs = collect();
    $comments = collect(); // Inisialisasi variabel comments

    // Menghitung jumlah tiket berdasarkan status
    $total_tiket = $tickets->count();
    $tiket_belum = $tickets->where('status.status_name', null)->count();
    $tiket_buka_proses = $tickets->whereIn('status.status_name', ['Diterima', 'Proses'])->count();
    $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
    $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();

    if ($selectedTicketId) {
        // Mengambil tiket yang dipilih
        $selectedTicket = $tickets->firstWhere('id', $selectedTicketId);

        if ($selectedTicket) {
            $selectedTicketNumber = $selectedTicket->no_ticket;

            $ticketNumbers = [$selectedTicketNumber];

            $logs = HistoryTicket::with('status', 'category', 'priority', 'customers', 'assignTo')
                ->whereIn('h_no_ticket', $ticketNumbers)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    // Mengambil semua tiket untuk dropdown
    $allTickets = Ticket::all();

    // Mengambil tiket prioritas
    $ticketPriotitas = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo')
        ->whereIn('priority_id', [3, 4])
        ->get();

    return view(
        'dashboard.admin.home.index',
        compact(
            'ticketPriotitas',
            'tickets',
            'total_tiket',
            'tiket_belum',
            'tiket_buka_proses',
            'tiket_tertunda',
            'tiket_selesai',
            'logs',
            'comments',
            'allTickets',
            'selectedTicketId',
            'selectedTicketNumber'
        )
    );
}

    public function getTicketChartData(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        $tickets = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->where(function ($query) {
                $query->where('status_id', 1)
                    ->orWhere('status_id', 2)
                    ->orWhere('status_id', 3);
            })
            ->groupBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        $ticketsClosed = Ticket::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
            ->whereYear('updated_at', $year)
            ->where('status_id', 4) // Assuming 4 is the ID for 'Tutup'
            ->groupBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        $chartData = [
            'months' => [],
            'tickets' => [],
            'ticketsClosed' => []
        ];

        for ($i = 1; $i <= 12; $i++) {
            $chartData['months'][] = Carbon::create()->month($i)->format('F');
            $chartData['tickets'][] = $tickets[$i]['total'] ?? 0;
            $chartData['ticketsClosed'][] = $ticketsClosed[$i]['total'] ?? 0;
        }

        return response()->json($chartData);
    }
}
