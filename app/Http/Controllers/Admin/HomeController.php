<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Ticket;
use App\Helpdesk;

class HomeController
{
    public function index()
    {
        abort_if(Gate::denies('dashboard_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $totalTickets = Helpdesk::count();
        $openTickets = Helpdesk::whereHas('status', function ($query) {
            $query->whereId('1');
        })->count();
        $closedTickets = Helpdesk::whereHas('status', function ($query) {
            $query->whereId('2');
        })->count();

        return view('admin.dashboard.index', compact('totalTickets', 'openTickets', 'closedTickets'));
    }
}
