<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
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
        $ticketsQuery = Ticket::with('status', 'category', 'priority', 'user_s', 'assignTo', 'statusChangedByUser');

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

        $tickets = Ticket::with('status', 'category', 'priority', 'user_s', 'assignTo', 'statusChangedByUser')
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

        $ticketPriotitas = Ticket::with('status', 'category', 'priority', 'user_s', 'assignTo', 'statusChangedByUser')
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
        $filterType = $request->input('filter', 'yearly'); // Default ke 'yearly' jika tidak ada filter yang dipilih
        $date = Carbon::now();

        switch ($filterType) {
            case 'weekly':
                $startOfWeek = Carbon::now()->startOfWeek(); // Mulai minggu (default: Senin)
                $endOfWeek = Carbon::now()->endOfWeek(); // Akhir minggu (default: Minggu)

                $tickets = Ticket::selectRaw('DAYOFWEEK(created_at) as day, COUNT(*) as total')
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->where(function ($query) {
                        $query->where('status_id', 1)
                            ->orWhere('status_id', 2)
                            ->orWhere('status_id', 3);
                    })
                    ->groupBy('day')
                    ->get()
                    ->keyBy('day')
                    ->toArray();

                $ticketsClosed = Ticket::selectRaw('DAYOFWEEK(updated_at) as day, COUNT(*) as total')
                    ->whereBetween('updated_at', [$startOfWeek, $endOfWeek])
                    ->where('status_id', 4)
                    ->groupBy('day')
                    ->get()
                    ->keyBy('day')
                    ->toArray();

                $chartData = [
                    'labels' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    'tickets' => [],
                    'ticketsClosed' => []
                ];

                for ($i = 1; $i <= 7; $i++) {
                    $chartData['tickets'][] = $tickets[$i]['total'] ?? 0;
                    $chartData['ticketsClosed'][] = $ticketsClosed[$i]['total'] ?? 0;
                }
                break;

            case 'monthly':
                $month = $date->month;

                $tickets = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $date->year)
                    ->where(function ($query) {
                        $query->where('status_id', 1)
                            ->orWhere('status_id', 2)
                            ->orWhere('status_id', 3);
                    })
                    ->groupBy('day')
                    ->get()
                    ->keyBy('day')
                    ->toArray();

                $ticketsClosed = Ticket::selectRaw('DAY(updated_at) as day, COUNT(*) as total')
                    ->whereMonth('updated_at', $month)
                    ->whereYear('updated_at', $date->year)
                    ->where('status_id', 4)
                    ->groupBy('day')
                    ->get()
                    ->keyBy('day')
                    ->toArray();

                $chartData = [
                    'labels' => [],
                    'tickets' => [],
                    'ticketsClosed' => []
                ];

                for ($i = 1; $i <= $date->daysInMonth; $i++) {
                    $chartData['labels'][] = $i;
                    $chartData['tickets'][] = $tickets[$i]['total'] ?? 0;
                    $chartData['ticketsClosed'][] = $ticketsClosed[$i]['total'] ?? 0;
                }
                break;

            case 'yearly':
            default:
                $year = $request->input('year', $date->year);

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
                    ->where('status_id', 4)
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month')
                    ->toArray();

                $chartData = [
                    'labels' => [],
                    'tickets' => [],
                    'ticketsClosed' => []
                ];

                for ($i = 1; $i <= 12; $i++) {
                    $chartData['labels'][] = Carbon::create()->month($i)->format('F');
                    $chartData['tickets'][] = $tickets[$i]['total'] ?? 0;
                    $chartData['ticketsClosed'][] = $ticketsClosed[$i]['total'] ?? 0;
                }
                break;
        }

        return response()->json($chartData);
    }
}
