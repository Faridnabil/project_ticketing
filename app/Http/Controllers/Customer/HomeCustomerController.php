<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HistoryTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeCustomerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedTicketId = $request->input('ticket_number');
        $selectedTicketNumber = null;

        // Initialize an empty collection for tickets
        $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo')->get();
        $logs = collect();

        // Menghitung jumlah tiket berdasarkan status
        $total_tiket = $tickets->count();
        $tiket_belum = $tickets->where('status.status_name', null)->count();
        $tiket_buka_proses = $tickets->whereIn('status.status_name', ['Diterima', 'Proses'])->count();
        $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
        $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();


        if ($selectedTicketId) {
            // Get the selected ticket
            $selectedTicket = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo')
                ->where('customer', $user->id)
                ->find($selectedTicketId);

            if ($selectedTicket) {
                $selectedTicketNumber = $selectedTicket->no_ticket;
                $tickets = collect([$selectedTicket]);

                $ticketNumbers = $tickets->pluck('no_ticket')->toArray();

                $logs = HistoryTicket::with('status', 'category', 'priority', 'customers', 'assignTo')
                    ->whereIn('h_no_ticket', $ticketNumbers)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        // Get all tickets for the dropdown
        $allTickets = Ticket::where('customer', $user->id)->get();

        return view('dashboard.customer.home.index', compact(
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
