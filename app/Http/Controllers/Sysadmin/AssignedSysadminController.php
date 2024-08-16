<?php

namespace App\Http\Controllers\Sysadmin;

use App\Http\Controllers\Controller;
use App\Exports\TicketsExport;
use App\Models\Ticket;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\HistoryTicket;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use App\Notifications\CommentDepartment;
use App\Notifications\NotificationAdmin;
use App\Notifications\NotificationCustomer;
use App\Notifications\NotificationDepartment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class AssignedSysadminController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $tickets = Ticket::with('status', 'category', 'priority', 'user_s', 'assignTo', 'statusChangedByUser')
            ->whereHas('assignTo', function ($query) use ($userId) {
                $query->where('id', $userId); // Menggunakan 'id' karena 'user_id' adalah primary key di tabel 'users'
            })
            ->get();

        $statuses = Status::all(); // Ambil semua status untuk dropdown filter
        $categories = Category::all(); // Ambil semua kategori untuk dropdown filter
        $priorities = Priority::all(); // Ambil semua prioritas untuk dropdown filter

        return view('dashboard.sysadmin.assigned-ticket.index', compact('tickets', 'statuses', 'categories', 'priorities'));
    }


    public function show($id)
    {
        $ticket = Ticket::find($id);
        $users_s = User::role('User')
            ->get();

        $assignTo = User::role(['DBA', 'SysAdmin'])
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $statusChangedBy = Auth::user();

        $logs = HistoryTicket::with('status', 'category', 'priority', 'user_s', 'assignTo')
            ->where('h_no_ticket', $ticket->no_ticket)
            ->orderBy('created_at', 'desc')
            ->get();


        $comments = Comment::where('ticket_id', $id)
            ->with('user')
            ->get();

        return view(
            'dashboard.sysadmin.assigned-ticket.show',
            compact(
                'ticket',
                'logs',
                'users_s',
                'priorities',
                'statuses',
                'categories',
                'comments',
                'statusChangedBy',
            )
        );
    }

    public function edit($id)
    {
        $ticket = Ticket::find($id);
        $users_s = User::role('User')
            ->get();

        $assignTo = User::role(['DBA', 'SysAdmin'])
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $statusChangedBy = Auth::user();

        $logs = ActivityLog::where('model_type', Ticket::class)
            ->where('model_id', $ticket)
            ->get();

        return view(
            'dashboard.sysadmin.assigned-ticket.edit',
            compact(
                'ticket',
                'users_s',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
                'statusChangedBy',
                'logs',
            )
        );
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Ambil tiket yang akan diupdate
            $ticket = Ticket::findOrFail($id);

            $validate = $request->all();
            $files = $request->file('attachments'); // Mengambil file dari input 'attachments'

            // Ambil file yang masih ada
            $existingAttachments = $ticket->attachments ? json_decode($ticket->attachments, true) : [];

            // Ambil file yang dihapus
            $removedAttachments = $request->input('removed_attachments') ? explode(',', $request->input('removed_attachments')) : [];

            // Filter file yang masih ada setelah penghapusan
            $remainingAttachments = array_diff($existingAttachments, $removedAttachments);

            // Proses file baru yang diupload
            $newAttachments = [];
            if ($files) {
                foreach ($files as $file) {
                    // Proses setiap file
                    $nama_file = time() . "_" . $file->getClientOriginalName();
                    $nama_folder = 'file/ticket';
                    $file->move(public_path($nama_folder), $nama_file);
                    $newAttachments[] = $nama_folder . "/" . $nama_file;
                }
            }

            // Gabungkan file baru dengan file yang masih ada
            $attachments = array_merge($remainingAttachments, $newAttachments);
            $validate['attachments'] = json_encode($attachments);

            // Update tiket dengan data baru
            $ticket->update($validate);

            // Simpan data tiket yang diupdate ke tabel history_tickets
            DB::table('history_tickets')->insert([
                'h_no_ticket' => $ticket->no_ticket,
                'h_title' => $ticket->title,
                'h_users' => $ticket->t_users,
                'h_assign_to' => $ticket->assign_to,
                'h_solution' => $ticket->solution,
                'h_priority_id' => $ticket->priority_id,
                'h_status_id' => $ticket->status_id,
                'h_category_id' => $ticket->category_id,
                'h_description' => $ticket->description,
                'h_attachments' => json_encode($attachments),
                'created_at' => now(),
                'updated_at' => now(),
                'status_changedBy' => Auth::user()->id,
            ]);

            $ticket->update($validate);

            // ------ Notifikasi --------------
            $statusName = $ticket->status->status_name;

            // Ambil nama pengguna yang ditugaskan
            $authenticatedUserName = Auth::user()->name;

            if ($statusName == 'Proses') {
                // Ambil semua pengguna dengan role Admin
                $adminUsers = User::role('Admin')->get();

                if ($adminUsers->isNotEmpty()) {
                    $notificationDataForAdmins = [
                        'name' => $authenticatedUserName,
                        'body' => 'Tiket diterima dan sedang diproses.',
                        'thanks' => 'Terimakasih',
                        'Text' => 'Silakan cek perkembangan tiket anda.',
                        'Url' => url('/admin/ticket'),
                        'ticket_id' => $ticket->no_ticket,
                        'type' => 'ticket_in_progress',
                    ];

                    // Kirim notifikasi ke semua pengguna Admin
                    Notification::send($adminUsers, new NotificationCustomer($notificationDataForAdmins));
                }
            } elseif ($statusName == 'Selesai') {
                // Cek apakah statusnya "Selesai"
                $tUsers = User::find($ticket->t_users);

                if ($tUsers) {
                    // Data notifikasi untuk pengguna yang memiliki tiket (t_users)
                    $notificationDataForTUsers = [
                        'name' => $authenticatedUserName,
                        'body' => 'Tiket yang anda ajukan telah selesai.',
                        'thanks' => 'Terimakasih',
                        'Text' => 'Silakan cek hasilnya.',
                        'Url' => url('/users/myTicket'),
                        'ticket_id' => $ticket->no_ticket,
                        'type' => 'ticket_completed',
                    ];

                    // Kirim notifikasi ke pengguna yang memiliki tiket
                    Notification::send($tUsers, new NotificationCustomer($notificationDataForTUsers));
                }
            }

            DB::commit();
            return redirect()->route('assignedSysadmin.index')->with('success', 'Tiket Berhasil Dirubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function store_comment(Request $request)
    {
        DB::beginTransaction();
        try {
            $comment = new Comment();
            $comment->ticket_id = $request->ticket_id;
            $comment->user_id = $request->user_id;
            $comment->message = $request->message;
            $comment->created_at = now();
            $comment->updated_at = null;
            $comment->save();

            $assignedDepartmentId = $request->assign_to;

            // Notifikasi
            $users = User::role(['User'])->where('id', $assignedDepartmentId)->get();
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

    public function completedTickets()
    {
        $userId = auth()->user()->id;
        $tickets = Ticket::with('status', 'category', 'priority', 'user_s', 'assignTo', 'statusChangedByUser')
            ->whereHas('assignTo', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->where('status_id', 4) // Status 4 adalah "Selesai"
            ->get();

        $statuses = Status::all(); // Semua status untuk dropdown filter

        return view('dashboard.sysadmin.assigned-ticket.completed', compact('tickets', 'statuses'));
    }

    public function export(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $user_id = auth()->user()->id;

        // Mendapatkan tanggal saat ini dengan format 'd-m-Y'
        $currentDate = Carbon::now()->format('d-m-Y');

        // Menyusun nama file dengan format 'laporan-tanggal_export.xlsx'
        $fileName = 'Laporan Tiket -' . $currentDate . '.xlsx';

        // Melakukan export dan men-download file dengan nama yang telah disusun
        return Excel::download(new TicketsExport($start_date, $end_date, $user_id), $fileName);
    }
}
