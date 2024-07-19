<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\NotificationAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


class RequestApprovalTicketController extends Controller
{
    public function update_ticket_approval(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->changed_assign_to = null;
        $ticket->approval_assign_to = $request->input('approval_assign') ? 2 : 0;

        // Set status_id berdasarkan nilai approval_assign_to
        if ($ticket->approval_assign_to == 2) {
            $ticket->status_id = 4;
        } else {
            $ticket->status_id = 3;
        }

        $ticket->save();

        // Pesan berdasarkan nilai approval_assign
        if ($ticket->approval_assign_to == 2) {
            $message = 'Tiket telah disetujui.';
            $bodyMessage = 'Tiket yang diajukan telah diterima dan selesai';
        } else {
            $message = 'Tiket ditolak.';
            $bodyMessage = 'Tiket yang diajukan ditolak';
        }

        // Ambil ID pengguna dari field `assign_to` yang sudah ada di tiket
        $changedAssignToUserId = $ticket->assign_to;

        // Temukan pengguna berdasarkan ID dari field `assign_to`
        $user = User::find($changedAssignToUserId);

        if ($user) {
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => $bodyMessage,
                'thanks' => 'Terimakasih',
                'Text' => '',
                'Url' => url('/department/assignedTicket'),
                'admin_id' => rand(1111, 9999),
            ];

            // Kirim notifikasi hanya kepada pengguna yang dipilih
            Notification::send($user, new NotificationAdmin($notificationData));
        }

        return redirect()->back()->with('success', $message);
    }

}
