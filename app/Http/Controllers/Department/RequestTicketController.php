<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\NotificationDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Cache;

class RequestTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;

        // Caching data tiket request selama 10 menit
        $requestTickets = Cache::remember("request_tickets_user_$userId", now()->addMinutes(10), function () use ($userId) {
            return Ticket::with('status', 'category', 'priority', 'customers', 'assignTo', 'changedAssignTo')
                ->where('changed_assign_to', $userId)
                ->get();
        });

        return view('dashboard.department.request-ticket.index', compact('requestTickets'));
    }

    public function request_ticket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->changed_assign_to = $request->changed_assign_to;
        $ticket->approval_assign_to = $request->approval_assign_to;
        $ticket->save();

        // Hapus cache karena data berubah
        Cache::forget("request_tickets_user_" . $request->changed_assign_to);

        $user = User::find($request->changed_assign_to);

        if ($user) {
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket telah dialihkan kepada anda',
                'thanks' => 'Terimakasih',
                'Text' => '',
                'Url' => url('/department/requestTicket'),
                'customer_id' => rand(1111, 9999),
            ];

            Notification::send($user, new NotificationDepartment($notificationData));
        }

        return redirect()->back()->with('success', 'Pengajuan telah dikirim.');
    }

    public function approve_ticket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $changedAssignToUserId = $ticket->changed_assign_to;

        $ticket->assign_to = $changedAssignToUserId;
        $ticket->changed_assign_to = null;
        $ticket->approval_assign_to = 0;

        $user = User::find($changedAssignToUserId);

        // Hapus cache user tersebut
        Cache::forget("request_tickets_user_$changedAssignToUserId");

        if ($user) {
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket telah dialihkan kepada anda dan disetujui',
                'thanks' => 'Terimakasih',
                'Text' => '',
                'Url' => url('/department/assignedTicket'),
                'customer_id' => rand(1111, 9999),
            ];

            Notification::send($user, new NotificationDepartment($notificationData));
        }

        $ticket->save();

        return redirect()->back()->with('success', 'Perubahan kepemilikan tiket telah disetujui.');
    }

    public function reject_ticket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $changedAssignToUserId = $ticket->assign_to;

        $ticket->changed_assign_to = null;
        $ticket->approval_assign_to = 0;

        // Hapus cache untuk user yang menolak
        Cache::forget("request_tickets_user_$changedAssignToUserId");

        $user = User::find($changedAssignToUserId);

        if ($user) {
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket kepemilikan telah ditolak',
                'thanks' => 'Terimakasih',
                'Text' => '',
                'Url' => url('/department/assignedTicket'),
                'customer_id' => rand(1111, 9999),
            ];

            Notification::send($user, new NotificationDepartment($notificationData));
        }

        $ticket->save();
        return redirect()->back()->with('success', 'Perubahan kepemilikan tiket telah ditolak.');
    }

    public function status_ticket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->changed_assign_to = null;
        $ticket->approval_assign_to = 0;

        $oldStatusId = $ticket->status_id;
        $ticket->status_id = $request->status_id;

        // Hapus cache untuk user yang bersangkutan
        Cache::forget("request_tickets_user_" . $ticket->assign_to);

        if ($request->status_id == 4) {
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket yang diambil ' . $authenticatedUserName . ', sudah terselesaikan',
                'thanks' => 'Terimakasih',
                'Text' => '',
                'Url' => url('/admin/ticket'),
                'customer_id' => rand(1111, 9999),
            ];

            $adminUsers = User::role('Admin')->get();

            foreach ($adminUsers as $admin) {
                Notification::send($admin, new NotificationDepartment($notificationData));
            }
        }

        $ticket->save();

        return redirect()->back()->with('success', 'Status Tiket telah diubah.');
    }
}
