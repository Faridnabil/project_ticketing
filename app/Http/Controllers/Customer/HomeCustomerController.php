<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HistoryTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeCustomerController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $selectedTicketId = $request->input('ticket_number');
    $selectedTicketNumber = null;

    // Buat cache key unik untuk tiket berdasarkan user
    $cacheKeyTickets = "tickets_user_{$user->id}";

    // Ambil tiket user dari cache atau query
    $tickets = Cache::remember($cacheKeyTickets, now()->addMinutes(30), function () use ($user) {
        return Ticket::with('status', 'category', 'priority', 'customers', 'assignTo')
            ->where('customer', $user->id)
            ->get();
    });

    $logs = collect(); // Default logs kosong

    // Hitung jumlah tiket berdasarkan status
    $total_tiket = $tickets->count();
    $tiket_belum = $tickets->where('status.status_name', null)->count();
    $tiket_buka_proses = $tickets->whereIn('status.status_name', ['Diterima', 'Proses'])->count();
    $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
    $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();

    if ($selectedTicketId) {
        // Cek cache untuk tiket yang dipilih
        $cacheKeySelectedTicket = "selected_ticket_{$selectedTicketId}_user_{$user->id}";
        $selectedTicket = Cache::remember($cacheKeySelectedTicket, now()->addMinutes(30), function () use ($selectedTicketId, $user) {
            return Ticket::with('status', 'category', 'priority', 'customers', 'assignTo')
                ->where('customer', $user->id)
                ->find($selectedTicketId);
        });

        if ($selectedTicket) {
            $selectedTicketNumber = $selectedTicket->no_ticket;
            $tickets = collect([$selectedTicket]);

            $ticketNumbers = [$selectedTicket->no_ticket];

            $cacheKeyLogs = "logs_ticket_" . md5(json_encode($ticketNumbers));
            $logs = Cache::remember($cacheKeyLogs, now()->addMinutes(30), function () use ($ticketNumbers) {
                return HistoryTicket::with('status', 'category', 'priority', 'customers', 'assignTo')
                    ->whereIn('h_no_ticket', $ticketNumbers)
                    ->orderBy('created_at', 'desc')
                    ->get();
            });
        }
    }

    // Untuk dropdown (ambil semua tiket customer)
    $cacheKeyAllTickets = "all_tickets_dropdown_user_{$user->id}";
    $allTickets = Cache::remember($cacheKeyAllTickets, now()->addMinutes(30), function () use ($user) {
        return Ticket::where('customer', $user->id)->get();
    });

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
