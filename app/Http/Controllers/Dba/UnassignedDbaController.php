<?php

namespace App\Http\Controllers\Dba;

use App\Http\Controllers\Controller;
use App\Models\HistoryTicket;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnassignedDbaController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('status', 'category', 'priority', 'assignTo', 'statusChangedByUser')
            ->where('assign_to', Auth::user()->id)
            ->where('status', 'Belum verifikasi')
            ->get();

        return view('dashboard.dba.unassigned-ticket.index', compact('tickets'));
    }

    public function countUnassignedTickets()
    {
        return Ticket::where('assign_to', Auth::user()->id)
            ->where('status', 'Belum verifikasi')
            ->count();
    }

    public function show($id)
    {
        $ticket = Ticket::find($id);
        $customers = User::role('User')->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $statusChangedBy = Auth::user();

        $logs = HistoryTicket::with('status', 'category', 'priority', 'assignTo')
            ->where('h_no_ticket', $ticket->no_ticket)
            ->orderBy('created_at', 'desc')
            ->get();

        $comments = Comment::where('ticket_id', $id)
            ->with('user')
            ->get();

        return view(
            'dashboard.dba.unassigned-ticket.show',
            compact(
                'ticket',
                'logs',
                'customers',
                'priorities',
                'statuses',
                'categories',
                'comments',
                'statusChangedBy',
            )
        );
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $priorities = Priority::all();
        $categories = Category::all();

        return view('dashboard.dba.unassigned-ticket.edit', compact('ticket', 'priorities', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'priority_id' => 'required|exists:priorities,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->priority_id = $request->input('priority_id');
        $ticket->category_id = $request->input('category_id');
        $ticket->save();

        return redirect()->route('unassignedDba.index')->with('success', 'Ticket berhasil diperbarui.');
    }

    public function verifyTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Update status tiket menjadi 'Verifikasi'
        $ticket->status_id = 1; // Asumsikan status_id 1 adalah 'Verifikasi'
        $ticket->status = 'Verifikasi';
        $ticket->save();

        // Hapus semua tiket dengan no_ticket yang sama dan status 'Belum verifikasi'
        Ticket::where('no_ticket', $ticket->no_ticket)
            ->where('status', 'Belum verifikasi')
            ->where('id', '!=', $ticket->id)
            ->delete();

        return redirect()->route('unassignedDba.index')->with('success', 'Ticket berhasil diverifikasi.');
    }

    public function rejectTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->status_id = 2; // Assuming status_id 2 corresponds to 'Tidak Aktif'
        $ticket->status = 'Verifikasi ditolak';

        $ticket->save();

        // Hapus semua tiket dengan no_ticket yang sama dan status 'Belum verifikasi'
        Ticket::where('no_ticket', $ticket->no_ticket)
            ->where('status', 'Belum verifikasi')
            ->where('id', '!=', $ticket->id)
            ->delete();

        return redirect()->route('unassignedDba.index')->with('success', 'Ticket berhasil ditolak.');
    }
}
