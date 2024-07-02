<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UnassignedTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'statusChangedByUser')
            ->whereDoesntHave('assignTo')
            ->get();

        return view('dashboard.unassigned-ticket.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::find($id);
        $customers = User::role('Customer')
            ->get();

        $assignTo = User::role('Department')
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $statusChangedBy = Auth::user();

        $logs = ActivityLog::where('model_type', Status::class)
            ->where('model_id', $ticket)
            ->get();

        return view(
            'dashboard.unassigned-ticket.show',
            compact(
                'ticket',
                'logs',
                'customers',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
                'statusChangedBy'
            )
        );
    }
}
