<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeDepartmentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $selectedTicketId = $request->input('ticket_number');
        $selectedTicketNumber = null;

        $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo', 'statusChangedByUser')
            ->where('assign_to', $user->id)
            ->get();

        if ($selectedTicketId) {
            $selectedTicket = $tickets->firstWhere('id', $selectedTicketId);
            if ($selectedTicket) {
                $selectedTicketNumber = $selectedTicket->no_ticket;
            }
        }

        $total_tiket = $tickets->count();
        $tiket_belum = $tickets->where('status.status_name', null)->count();

        $tiket_proses = $tickets->whereIn('status.status_name', ['Diterima', 'Proses'])->count();

        $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
        $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();


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

        return view('dashboard.department.home.index', compact(
            'tickets',
            'total_tiket',
            'tiket_proses',
            'tiket_tertunda',
            'tiket_selesai',
            'logs',
            'selectedTicketId',
            'selectedTicketNumber'
        ));
    }
}
