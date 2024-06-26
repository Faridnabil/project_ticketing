<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class AssignedTicketController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo', 'statusChangedByUser')
            ->whereHas('assignTo', function ($query) use ($userId) {
                $query->where('id', $userId); // Menggunakan 'id' karena 'user_id' adalah primary key di tabel 'users'
            })
            ->get();

        return view('dashboard.assigned-ticket.index', compact('tickets'));
    }
}
