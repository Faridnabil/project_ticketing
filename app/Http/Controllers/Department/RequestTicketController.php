<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\NotificationDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

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

        // Temukan pengguna berdasarkan ID
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

            // Kirim notifikasi hanya kepada pengguna yang dipilih
            Notification::send($user, new NotificationDepartment($notificationData));
        }
        return redirect()->back()->with('success', 'Pengajuan telah dikirim.');
    }


    public function approve_ticket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // Ambil ID pengguna dari field `changed_assign_to` yang sudah ada di tiket
        $changedAssignToUserId = $ticket->changed_assign_to;

        // Update data tiket
        $ticket->assign_to = $changedAssignToUserId;
        $ticket->changed_assign_to = null;
        $ticket->approval_assign_to = 0;

        // Temukan pengguna berdasarkan ID dari field `changed_assign_to`
        $user = User::find($changedAssignToUserId);

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

            // Kirim notifikasi hanya kepada pengguna yang dipilih
            Notification::send($user, new NotificationDepartment($notificationData));
        }

        // Simpan perubahan data tiket setelah notifikasi dikirim
        $ticket->save();

        return redirect()->back()->with('success', 'Perubahan kepemilikan tiket telah disetujui.');
    }

    public function reject_ticket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // Ambil ID pengguna dari field `assign_to` yang sudah ada di tiket
        $changedAssignToUserId = $ticket->assign_to;

        $ticket->changed_assign_to = null;
        $ticket->approval_assign_to = 0;

        // Temukan pengguna berdasarkan ID dari field `assign_to`
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

            // Kirim notifikasi hanya kepada pengguna yang dipilih
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

        // Simpan status_id yang lama sebelum mengubahnya
        $oldStatusId = $ticket->status_id;

        // Update status_id dengan yang baru dari request
        $ticket->status_id = $request->status_id;

        // Periksa apakah status_id berubah menjadi 4
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

            // Ambil semua pengguna dengan peran 'admin'
            $adminUsers = User::role('Admin')
            ->get();

            // Kirim notifikasi kepada semua pengguna dengan peran 'admin'
            foreach ($adminUsers as $admin) {
                Notification::send($admin, new NotificationDepartment($notificationData));
            }
        }

        $ticket->save();

        return redirect()->back()->with('success', 'Status Tiket telah diubah.');
    }

}
