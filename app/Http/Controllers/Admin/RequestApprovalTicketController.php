<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;

class RequestApprovalTicketController extends Controller
{
    public function update_ticket_approval(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->changed_assign_to = null;
        $ticket->approval_assign_to = $request->input('approval_assign') ? 2 : 0;

        // Set status_id based on the value of approval_assign_to
        if ($ticket->approval_assign_to == 2) {
            $ticket->status_id = 4;
        } else {
            $ticket->status_id = 3;
        }

        $ticket->save();

        if ($request->input('approval_assign')) {
            $message = 'Tiket telah disetujui.';
        } else {
            $message = 'Tiket ditolak.';
        }

        return redirect()->back()->with('success', $message);
    }

}
