<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AllTicketsExport;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HistoryTicket;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Priority;
use App\Models\RequestAssignment;
use App\Models\Status;
use App\Models\User;
use App\Notifications\NotificationAdmin;
use App\Notifications\NotificationCustomer;
use App\Notifications\NotificationDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with('status', 'category', 'priority', 'user_s', 'assignTo', 'statusChangedByUser');

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('assign_to') && $request->assign_to) {
            $query->where('assign_to', $request->assign_to);
        }

        if ($request->has('priority_id') && $request->priority_id) {
            $query->where('priority_id', $request->priority_id);
        }

        if ($request->has('status_id') && $request->status_id) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $tickets = $query->orderBy('id', 'desc')->get();

        // Fetch necessary data for filters
        $assign_to = User::role(['DBA', 'SysAdmin'])->get();
        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        return view('dashboard.admin.ticket.index', compact('tickets', 'categories', 'assign_to', 'priorities', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_s = User::role('User')->get();
        $assign_to = User::role(['DBA', 'SysAdmin'])->get();
        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        return view('dashboard.admin.ticket.create', compact('users_s', 'assign_to', 'priorities', 'statuses', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Generate ticket_id baru
            $lastTicket = Ticket::orderBy('id', 'desc')->first();
            $newTicketIdNumber = $lastTicket ? intval(substr($lastTicket->ticket_id, 5)) + 1 : 1;
            $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);

            // Pastikan ticket_id unik
            while (Ticket::where('no_ticket', $newTicketId)->exists()) {
                $newTicketIdNumber++;
                $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);
            }

            $validate = $request->all();
            $files = $request->file('attachments'); // Mengambil file dari input 'attachments'
            $validate['no_ticket'] = $newTicketId;

            $attachments = [];
            if ($files) {
                foreach ($files as $file) {
                    // Proses setiap file
                    $nama_file = time() . "_" . $file->getClientOriginalName();
                    $nama_folder = 'file/ticket';
                    $file->move(public_path($nama_folder), $nama_file);
                    $attachments[] = $nama_folder . "/" . $nama_file;
                }
            }

            $validate['attachments'] = json_encode($attachments);

            // Menetapkan status menjadi "Diterima" jika tiket ditugaskan ke tenaga ahli
            if (isset($validate['assign_to'])) {
                $validate['status_id'] = 2; // Ganti 2 dengan ID status "Diterima" yang sesuai
            }

            // Simpan data tiket sebelum diupdate ke tabel history_ticket
            DB::table('history_tickets')->insert([
                'h_no_ticket' => $validate['no_ticket'],
                'h_title' => $request->title,
                'h_users' => $request->t_users,
                'h_assign_to' => $request->assign_to,
                'h_solution' => $request->solution,
                'h_priority_id' => $request->priority_id,
                'h_status_id' => $request->status_id,
                'h_category_id' => $request->category_id,
                'h_description' => $request->description,
                'h_attachments' => json_encode($attachments),
                'created_at' => now(),
                'updated_at' => now(),
                'status_changedBy' => Auth::user()->id,
            ]);

            Ticket::create($validate);
            DB::commit();
            return redirect()->route('ticket.index')->with('success', 'Tiket Berhasil Dibuat.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);
        $users = User::role('User')->get();
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

        return view('dashboard.admin.ticket.show', compact('ticket', 'logs', 'users', 'priorities', 'statuses', 'categories', 'comments', 'statusChangedBy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $users = User::role('User')->get();
        $assignTo = User::role(['DBA', 'SysAdmin'])->get();
        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();
        $statusChangedBy = Auth::user();
        $logs = ActivityLog::where('model_type', Ticket::class)->where('model_id', $ticket->id)->get();

        return view('dashboard.admin.ticket.edit', compact('ticket', 'users', 'assignTo', 'priorities', 'statuses', 'categories', 'statusChangedBy', 'logs'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Ambil tiket yang akan diupdate
            $ticket = Ticket::findOrFail($id);

            $validate = $request->all();
            $files = $request->file('attachments'); // Mengambil file dari input 'attachments'

            // Ambil file yang masih ada (jika ada) dari request
            $existingAttachments = $ticket->attachments ? json_decode($ticket->attachments, true) : [];

            // Proses file baru yang diupload
            $newAttachments = [];
            if ($files) {
                foreach ($files as $file) {
                    // Proses setiap file
                    $fileName = time() . "_" . $file->getClientOriginalName();
                    $folderName = 'file/ticket';
                    $file->move(public_path($folderName), $fileName);
                    $newAttachments[] = $folderName . "/" . $fileName;
                }
            }

            // Gabungkan file yang masih ada dengan file baru
            $allAttachments = array_merge($existingAttachments, $newAttachments);
            $validate['attachments'] = json_encode($allAttachments);

            // --- Notifikasi
            // Update tiket dengan data baru
            $ticket->update($validate);

            // Ambil status tiket berdasarkan nama status
            $statusName = $ticket->status->status_name;

            // Ambil nama pengguna yang ditugaskan
            $authenticatedUserName = Auth::user()->name;
            $assignedUser = User::find($ticket->assign_to);

            if (in_array($statusName, ['Diterima', 'Proses'])) {
                if ($assignedUser) {
                    // Tentukan URL berdasarkan peran pengguna yang ditugaskan
                    $url = '';
                    if ($assignedUser->hasRole('DBA')) {
                        $url = url('/dba/assignedDba');
                    } elseif ($assignedUser->hasRole('SysAdmin')) {
                        $url = url('/sysadmin/assignedSysadmin');
                    }

                    $notificationDataForAssignedUser = [
                        'name' => $authenticatedUserName,
                        'body' => 'Tiket baru telah ditugaskan kepada anda.',
                        'thanks' => 'Terimakasih',
                        'Text' => 'Silakan cek tiket yang ditugaskan kepada anda.',
                        'Url' => $url,
                        'ticket_id' => $ticket->no_ticket,
                        'type' => 'ticket_assigned',
                    ];

                    // Kirim notifikasi ke pengguna yang ditugaskan
                    Notification::send($assignedUser, new NotificationCustomer($notificationDataForAssignedUser));
                }

                // Notifikasi untuk pengguna yang memiliki tiket (t_users)
                $tUsers = User::find($ticket->t_users);

                if ($tUsers) {
                    $notificationDataForCustomer = [
                        'name' => $authenticatedUserName,
                        'body' => 'Tiket anda sudah diterima dan sedang diproses.',
                        'thanks' => 'Terimakasih',
                        'Text' => 'Silakan cek perkembangan tiket anda.',
                        'Url' => url('/users/myTicket'),
                        'ticket_id' => $ticket->no_ticket,
                        'type' => 'ticket_in_progress',
                    ];

                    Notification::send($tUsers, new NotificationCustomer($notificationDataForCustomer));
                }
            } elseif ($statusName == 'Selesai') {
                // Jika status_name adalah 'Selesai', kirim notifikasi ke pengguna yang memiliki tiket (t_users)
                $tUsers = User::find($ticket->t_users);

                if ($tUsers) {
                    $notificationDataForTUsers = [
                        'name' => $authenticatedUserName,
                        'body' => 'Tiket yang anda ajukan telah selesai.',
                        'thanks' => 'Terimakasih',
                        'Text' => 'Silakan cek hasilnya.',
                        'Url' => url('/users/myTicket'),
                        'ticket_id' => $ticket->no_ticket,
                        'type' => 'ticket_completed',
                    ];

                    // Kirim notifikasi ke pengguna yang ada di field t_users
                    Notification::send($tUsers, new NotificationCustomer($notificationDataForTUsers));
                }
            }

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
                'h_attachments' => $ticket->attachments,
                'created_at' => now(),
                'updated_at' => now(),
                'status_changedBy' => Auth::user()->id,
            ]);

            DB::commit();
            return redirect()->route('ticket.index')->with('success', 'Tiket Berhasil Diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Hapus file terkait
        if ($ticket->attachments) {
            $attachments = json_decode($ticket->attachments, true);
            foreach ($attachments as $attachment) {
                $filePath = public_path($attachment);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $ticket->delete();
        return redirect()->route('ticket.index')->with('success', 'Tiket Berhasil Dihapus.');
    }
    public function approve_assignment(Request $request, RequestAssignment $requestAssignment)
    {
        if (Auth::user()->hasRole('Admin')) {
            $ticket = $requestAssignment->ticket;
            $ticket->assign_to = $requestAssignment->user_id;

            // Ubah status tiket menjadi "Diterima"
            $statusDiterima = Status::where('status_name', 'Diterima')->first();
            if ($statusDiterima) {
                $ticket->status_id = $statusDiterima->id;
            }

            $ticket->save();

            $requestAssignment->status_id = 2; // status_id 2 untuk 'Approved'
            $requestAssignment->save();

            // Notifikasi untuk Tenaga Ahli yang ditugaskan
            $authenticatedUserName = Auth::user()->name;
            $assignedUser = User::find($ticket->assign_to);

            $url = '';
            if ($assignedUser->hasRole('DBA')) {
                $url = url('/dba/assignedDba');
            } elseif ($assignedUser->hasRole('SysAdmin')) {
                $url = url('/sysadmin/assignedSysadmin');
            }

            $notificationDataForExpert = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket yang anda ajukan telah diterima dan sedang diproses.',
                'thanks' => 'Terimakasih',
                'Text' => 'Tolong cek kembali tiket anda.',
                'Url' => $url,
                'ticket_id' => $ticket->no_ticket,
                'type' => 'assignment_approved',
            ];

            Notification::send($assignedUser, new NotificationCustomer($notificationDataForExpert));

            // Catat riwayat perubahan status tiket
            DB::table('history_tickets')->insert([
                'h_no_ticket' =>  $ticket->no_ticket,
                'h_title' => $ticket->title,
                'h_users' => $ticket->t_users,
                'h_assign_to' => $ticket->assign_to,
                'h_solution' => $ticket->solution,
                'h_priority_id' => $ticket->priority_id,
                'h_status_id' => $ticket->status_id,
                'h_category_id' => $ticket->category_id,
                'h_description' => $ticket->description,
                'h_attachments' => $ticket->attachments,
                'created_at' => now(),
                'updated_at' => now(),
                'status_changedBy' => Auth::user()->id,
            ]);

            return redirect()->back()->with('success', 'Tiket berhasil diassign.');
        }

        return redirect()->back()->with('error', 'Anda tidak berhak untuk menyetujui pengajuan ini.');
    }

    // method to download tickets in excel
    public function export(Request $request)
    {
        return Excel::download(new AllTicketsExport($request), 'alltickets.xlsx');
    }
}
