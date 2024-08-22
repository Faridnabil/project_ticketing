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
use App\Notifications\NotificationCustomer;
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

        // Mengambil tiket yang sudah diverifikasi dan ditugaskan ke SysAdmin yang sedang login
        $tickets = Ticket::with('status', 'category', 'priority', 'assignTo', 'statusChangedByUser')
            ->where('status', 'Verifikasi') // Pastikan tiket sudah diverifikasi
            ->whereHas('assignTo', function ($query) use ($userId) {
                $query->where('id', $userId); // Filter tiket berdasarkan SysAdmin yang sedang login
            })
            ->get();

        // Ambil semua status, kategori, dan prioritas untuk dropdown filter
        $statuses = Status::all();
        $categories = Category::all();
        $priorities = Priority::all();

        return view('dashboard.sysadmin.assigned-ticket.index', compact('tickets', 'statuses', 'categories', 'priorities'));
    }

    public function countAssignedTickets()
    {
        return Ticket::where('assign_to', Auth::user()->id)
        ->where('status_id', [1, 3])
        ->count();
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

        $logs = HistoryTicket::with('status', 'category', 'priority', 'assignTo')
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

    public function completedTickets()
    {
        $userId = auth()->user()->id;
        $tickets = Ticket::with('status', 'category', 'priority', 'assignTo', 'statusChangedByUser')
            ->where('assign_to', $userId)
            ->where(function ($query) {
                $query->where('status_id', 4) // Status 'Selesai'
                    ->orWhere('status_id', 2) // Status 'Tidak Aktif'
                    ->orWhere('status', 'Verifikasi ditolak'); // Status 'Verifikasi ditolak'
            })
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
