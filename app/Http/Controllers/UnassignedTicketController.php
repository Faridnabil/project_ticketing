<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class UnassignedTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'statusChangedByUser')
            ->whereDoesntHave('assignTo')
            ->get();

        return view('dashboard.unassigned-ticket.index', compact('tickets'));
    }

}
