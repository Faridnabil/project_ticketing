<?php

namespace App\Http\Controllers\Engineer;

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

class EngineerTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with('statuses', 'category', 'priority', 'assignTo', 'statusChangedByUser');

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('assign_to') && $request->assign_to) {
            $query->where('assign_to', $request->assign_to);
        }
        if ($request->has('priority_id') && $request->priority_id) {
            $query->where('priority_id', $request->priority_id);
        }

        if ($request->has('status_id') && $request->status_id) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $tickets = $query->orderBy('id', 'desc')->get();

        // Fetch necessary data for filters
        $assign_to = User::role(['DBA', 'SysAdmin'])->get();
        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        return view('dashboard.engineer.ticket.index', compact('tickets', 'assign_to', 'categories', 'priorities', 'statuses'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);
        $users = User::role('User')->get();
        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();
        $statusChangedBy = Auth::user();

        $logs = HistoryTicket::with('statuses', 'category', 'priority', 'assignTo')
            ->where('h_no_ticket', $ticket->no_ticket)
            ->orderBy('created_at', 'desc')
            ->get();

        $comments = Comment::where('ticket_id', $id)
            ->with('user')
            ->get();

        return view('dashboard.engineer.ticket.show', compact('ticket', 'logs', 'users', 'priorities', 'statuses', 'categories', 'comments', 'statusChangedBy'));
    }
}
