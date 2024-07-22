<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Priority;
use App\Models\RequestAssignment;
use App\Models\Status;
use App\Models\User;
use App\Notifications\CommentDepartment;
use App\Notifications\NotificationDepartment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class UnassignedTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'statusChangedByUser')
            ->whereDoesntHave('assignTo')
            ->get();

        return view('dashboard.department.unassigned-ticket.index', compact('tickets'));
    }

    public function request_assignment(Request $request, Ticket $ticket)
    {
        // Pastikan user yang sedang login memiliki role 'Department' dan tiket belum diassign ke siapa pun
        if (Auth::user()->hasRole('Tenaga Ahli') && $ticket->assign_to === null) {
            // Periksa apakah pengajuan sudah ada
            $existingRequest = RequestAssignment::where('ticket_id', $ticket->id)
                ->where('user_id', Auth::id())
                ->exists();

            if ($existingRequest) {
                return redirect()->back()->with('error', 'Anda sudah mengajukan untuk tiket ini.');
            }

            // Notifikasi kepada admin dengan role 'Department'
            $users = User::role('Admin')->get();
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Ada permintaan, untuk tiket yang belum ditetapkan.',
                'thanks' => 'Terima kasih.',
                'Text' => 'Tolong perbaiki lagi.',
                'Url' => url('/approve-assignment'), // Perbaikan pada URL
                'department_id' => rand(1111, 9999),
            ];

            Notification::send($users, new NotificationDepartment($notificationData));

            // Simpan permintaan penugasan ke dalam tabel request_assignments
            RequestAssignment::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'status_id' => 1 // status_id 1 untuk 'Pending'
            ]);

            return redirect()->back()->with('success', 'Permintaan penugasan berhasil dikirim. Menunggu persetujuan admin.');
        }

        return redirect()->back()->with('error', 'Permintaan penugasan gagal. Anda tidak memiliki hak untuk mengajukan.');
    }


    public function show($id)
    {
        $ticket = Ticket::find($id);
        $customers = User::role('Customer')->get();
        $assignTo = User::role('Tenaga Ahli')->get();
        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();
        $statusChangedBy = Auth::user();

        $logs = ActivityLog::where('model_type', Ticket::class)
            ->where('model_id', $ticket)
            ->latest()
            ->get();

        $comments = Comment::where('ticket_id', $id)
            ->with('user')
            ->get();

        return view(
            'dashboard.department.unassigned-ticket.show',
            compact(
                'ticket',
                'logs',
                'customers',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
                'statusChangedBy',
                'comments'
            )
        );
    }

    public function store_comment(Request $request)
    {
        DB::beginTransaction();
        try {
            $comment = new Comment();
            $comment->ticket_id = $request->ticket_id;
            $comment->user_id =  $request->user_id;
            $comment->message = $request->message;
            $comment->created_at = now();
            $comment->updated_at = null;
            $comment->save();

            $assignedDepartmentId = $request->assign_to;

            // Notifikasi
            $users = User::role(['Customer'])->where('id', $assignedDepartmentId)->get();
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Ada komentar baru pada tiket anda',
                'thanks' => 'Terimakasih',
                'Text' => 'Tolong cek kembali',
                'Url' => url('/customer/myTicket/' . $comment->ticket_id),
                'department_id' => rand(1111, 9999),
                'type' => 'comment', // Menambahkan properti 'type'
            ];

            Notification::send($users, new CommentDepartment($notificationData));

            DB::commit();

            return redirect()->back()->with([
                'success' => 'Komen telah terbuat!',
                'new_comment_id' => $comment->id
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Komentar anda tidak tersimpan!');
        }
    }


    public function update_comment(Request $request, $id)
    {
        // Cari komentar berdasarkan ID
        $comment = Comment::find($id);

        // Pastikan komentar ditemukan
        if (!$comment) {
            return redirect()->back()->with('error', 'Comment not found.');
        }

        // Cek apakah ticket_id yang diberikan ada dalam tabel tickets
        $ticket = Ticket::find($request->ticket_id);
        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found.');
        }

        // Perbarui atribut-atribut komentar
        $comment->ticket_id = $request->ticket_id;
        $comment->user_id = auth()->id();
        $comment->message = $request->message;
        $comment->save();

        return redirect()->back()->with('success', 'Comment updated successfully!');
    }
}
