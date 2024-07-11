<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Attendance;
use App\Models\Ticket;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeAdminController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil filter dari request
        $ticketNumber = $request->input('ticket_number');

        // Mengambil semua data tiket untuk mengisi filter dropdown
        $allTickets = Ticket::all();

        // Mengambil data tiket dan menerapkan filter nomor tiket jika ada
        $ticketsQuery = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo', 'statusChangedByUser');

        if ($ticketNumber) {
            $ticketsQuery->where('id', $ticketNumber);
        }

        $tickets = $ticketsQuery->get();

        // Menghitung jumlah tiket berdasarkan status
        $total_tiket = $tickets->count();
        $tiket_belum = $tickets
            ->where('status.status_name', null)
            ->count();
        $tiket_buka = $tickets
            ->where('status.status_name', 'Diterima')
            ->count();
        $tiket_proses = $tickets
            ->where('status.status_name', 'Proses')
            ->count();
        $tiket_tertunda = $tickets
            ->where('status.status_name', 'Tertunda')
            ->count();
        $tiket_selesai = $tickets
            ->where('status.status_name', 'Selesai')
            ->count();

        // Mendapatkan data logs dan comments untuk setiap tiket
        $logs = collect();
        $comments = collect();

        foreach ($tickets as $ticket) {
            $ticketLogs = ActivityLog::where('model_type', Ticket::class)
                ->where('model_id', $ticket->id)
                ->get();
            $logs = $logs->merge($ticketLogs);

            $ticketComments = Comment::where('ticket_id', $ticket->id)
                ->with('user')
                ->get();
            $comments = $comments->merge($ticketComments);
        }

        $selectedTicketId = $request->input('ticket_number');
        $selectedTicketNumber = null;

        $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo', 'statusChangedByUser')
            ->get();

        if ($selectedTicketId) {
            $selectedTicket = $tickets->firstWhere('id', $selectedTicketId);
            if ($selectedTicket) {
                $selectedTicketNumber = $selectedTicket->no_ticket;
            }
        }

        $logs = collect();

        if ($selectedTicketId) {
            $ticketLogs = ActivityLog::where('model_type', Ticket::class)
                ->where('model_id', $selectedTicketId)
                ->get();
            $logs = $logs->merge($ticketLogs);
        } else {
            foreach ($tickets as $ticket) {
                $ticketLogs = ActivityLog::where('model_type', Ticket::class)
                    ->where('model_id', $ticket->id)
                    ->get();
                $logs = $logs->merge($ticketLogs);
            }
        }

        $ticketPriotitas = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo', 'statusChangedByUser')
        ->whereIn('priority_id', [2, 4]) // Pastikan filter priority_id juga diterapkan di sini
        ->get();

        return view(
            'dashboard.admin.home.index',
            compact(
                'ticketPriotitas',
                'tickets',
                'total_tiket',
                'tiket_belum',
                'tiket_buka',
                'tiket_proses',
                'tiket_tertunda',
                'tiket_selesai',
                'logs',
                'comments',
                'allTickets',
                'logs',
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
