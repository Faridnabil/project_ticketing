<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        $tiket_proses = $tickets->where('status.status_name', 'Berlangsung')->count();
        $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
        $tiket_selesai = $tickets->where('status.status_name', 'Tutup')->count();

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

        return view('dashboard.admin.home.index', compact(
            'tickets',
            'total_tiket',
            'tiket_proses',
            'tiket_tertunda',
            'tiket_selesai',
            'logs',
            'comments',
            'allTickets'
        ));
    }
}
