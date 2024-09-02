<?php

namespace App\Http\Controllers\Sysadmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HistoryTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeSysadminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedTicketId = $request->input('ticket_number');
        $selectedTicketNumber = null;

        // Initialize an empty collection for tickets
        $tickets = Ticket::with('statuses', 'category', 'priority', 'assignTo')
        ->where('assign_to', $user->id)
        ->get();
        $logs = collect();

        // Menghitung jumlah tiket berdasarkan status
        $total_tiket = $tickets->count();
        $tiket_belum = $tickets->where('statuses.status_name', null)->count();
        $tiket_buka_proses = $tickets->whereIn('statuses.status_name', ['Aktif', 'Proses'])->count();
        $tiket_tertunda = $tickets->where('statuses.status_name', 'Tertunda')->count();
        $tiket_selesai = $tickets->where('statuses.status_name', 'Selesai')->count();


        if ($selectedTicketId) {
            // Get the selected ticket
            $selectedTicket = Ticket::with('statuses', 'category', 'priority', 'assignTo')
                ->where('assign_to', $user->id)
                ->find($selectedTicketId);

            if ($selectedTicket) {
                $selectedTicketNumber = $selectedTicket->no_ticket;
                $tickets = collect([$selectedTicket]);

                $ticketNumbers = $tickets->pluck('no_ticket')->toArray();

                $logs = HistoryTicket::with('statuses', 'category', 'priority', 'assignTo')
                    ->whereIn('h_no_ticket', $ticketNumbers)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        // Get all tickets for the dropdown
        $allTickets = Ticket::where('assign_to', $user->id)->get();

        return view('dashboard.sysadmin.home.index', compact(
            'allTickets',
            'tickets',
            'total_tiket',
            'tiket_buka_proses',
            'tiket_tertunda',
            'tiket_selesai',
            'logs',
            'selectedTicketId',
            'selectedTicketNumber'
        ));
    }
}
