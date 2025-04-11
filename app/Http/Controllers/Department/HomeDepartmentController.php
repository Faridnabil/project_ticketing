<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\HistoryTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeDepartmentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $selectedTicketId = $request->input('ticket_number');
        $selectedTicketNumber = null;

        // Ambil tiket dari cache atau database
        $tickets = Cache::remember("department_tickets_$userId", now()->addMinutes(10), function () {
            return Ticket::with('status', 'category', 'priority', 'customers', 'assignTo')->get();
        });

        // Hitung total dan status tiket
        $total_tiket = $tickets->count();
        $tiket_belum = $tickets->where('status.status_name', null)->count();
        $tiket_buka_proses = $tickets->whereIn('status.status_name', ['Diterima', 'Proses'])->count();
        $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
        $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();

        $logs = collect();

        // Filter dan ambil log berdasarkan tiket yang dipilih
        if ($selectedTicketId) {
            $selectedTicket = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo')
                ->where('assign_to', $userId)
                ->find($selectedTicketId);

            if ($selectedTicket) {
                $selectedTicketNumber = $selectedTicket->no_ticket;
                $tickets = collect([$selectedTicket]);

                $ticketNumbers = $tickets->pluck('no_ticket')->toArray();

                $logs = Cache::remember("department_logs_$userId" . "_" . $selectedTicketId, now()->addMinutes(10), function () use ($ticketNumbers) {
                    return HistoryTicket::with('status', 'category', 'priority', 'customers', 'assignTo')
                        ->whereIn('h_no_ticket', $ticketNumbers)
                        ->orderBy('created_at', 'desc')
                        ->get();
                });
            }
        }

        // Ambil dropdown tiket berdasarkan user assign_to
        $allTickets = Cache::remember("department_dropdown_tickets_$userId", now()->addMinutes(10), function () use ($userId) {
            return Ticket::where('assign_to', $userId)->get();
        });

        return view('dashboard.department.home.index', compact(
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
