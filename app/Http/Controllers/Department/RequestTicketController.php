<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestTickets = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo', 'changedAssignTo')
            ->where('changed_assign_to', Auth::user()->id)
            ->get();

        return view('dashboard.department.request-ticket.index', compact('requestTickets'));
    }

    public function request_ticket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->changed_assign_to = $request->changed_assign_to;
        $ticket->approval_assign_to = $request->approval_assign_to;
        $ticket->save();

        return redirect()->back()->with('success', 'Pengajuan telah dikirim.');

    }

    public function approve_ticket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->assign_to = $ticket->changed_assign_to;
        $ticket->changed_assign_to = null;
        $ticket->approval_assign_to = 0;
        $ticket->save();

        return redirect()->back()->with('success', 'Perubahan kepemilikan tiket telah disetujui.');
    }

    public function reject_ticket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->changed_assign_to = null;
        $ticket->approval_assign_to = 0;
        $ticket->save();

        return redirect()->back()->with('success', 'Perubahan kepemilikan tiket telah ditolak.');
    }
}
