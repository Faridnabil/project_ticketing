<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HistoryTicket;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use App\Notifications\CommentCustomer;
use App\Notifications\NotificationCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class TicketUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $tickets = Ticket::with('status', 'category', 'priority', 'user_s', 'assignTo')
            ->whereHas('user_s', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->where('status_id', '!=', 4)
            ->get();

        return view('dashboard.users.ticket.index', compact('tickets'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $t_user = User::role('User')
            ->where('id', $user->id)
            ->get();

        $assignTo = User::role(['Sysadmin', 'DBA'])
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        return view(
            'dashboard.users.ticket.create',
            compact(
                't_user',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
            )
        );
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

            // Notifikasi
            $users = User::role(['Admin'])->get();
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Menunggu konfirmasi Tiket',
                'thanks' => 'Terimakasih',
                'Text' => 'Tolong cek Kembali',
                'Url' => url('/admin/ticket'),
                'customer_id' => rand(1111, 9999),
            ];

            Notification::send($users, new NotificationCustomer($notificationData));

            $validate['attachments'] = json_encode($attachments);

            // Simpan data tiket sebelum diupdate ke tabel history_ticket
            DB::table('history_tickets')->insert([
                'h_no_ticket' => $validate['no_ticket'] = $newTicketId,
                'h_title' => $request->title,
                'h_users' => $request->t_users,
                'h_assign_to' => $request->assign_to,
                'h_solution' => $request->solution,
                'h_priority_id' => $request->priority_id,
                'h_status_id' => $request->status_id,
                'h_category_id' => $request->category_id,
                'h_description' => $request->description,
                'h_attachments' => json_encode($attachments), // Ensure this is JSON encoded
                'created_at' => now(),
                'updated_at' => now(),
                'status_changedBy' => Auth::user()->id,
            ]);

            Ticket::create($validate);
            DB::commit();
            return redirect()->route('myTicket.index')->with('success', 'Tiket Berhasil Dibuat.');
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
        $t_users = User::role('User')
            ->get();

        // $assignTo = User::role('Department')
        //     ->get();

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
            'dashboard.users.ticket.show',
            compact(
                'ticket',
                'logs',
                't_users',
                'priorities',
                'statuses',
                'categories',
                'comments',
                'statusChangedBy'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);

        $t_users = User::role('User')
            ->get();

        $assignTo = User::role(['SysAdmin', 'DBA'])
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $statusChangedBy = Auth::user();

        $logs = ActivityLog::where('model_type', Ticket::class)
            ->where('model_id', $ticket->id)
            ->get();

        return view(
            'dashboard.users.ticket.edit',
            compact(
                'ticket',
                't_users',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
                'statusChangedBy',
                'logs',
            )
        );
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

            // Validasi data dari request
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
                'h_attachments' => json_encode($allAttachments), // Pastikan ini terkodekan dalam JSON
                'created_at' => now(),
                'updated_at' => now(),
                'status_changedBy' => Auth::user()->id,
            ]);

            DB::commit();
            return redirect()->route('myTicket.index')->with('success', 'Tiket Berhasil Diupdate.');
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
        DB::beginTransaction();
        try {
            $ticket = Ticket::find($id);

            if (!$ticket) {
                // Jika principle tidak ditemukan, kembalikan pesan kesalahan
                return back()->with(['error' => 'Tiket Tidak ada.']);
            }
            DB::commit();
            $ticket->delete(); // Hapus principle
            return redirect()->route('myTicket.index')->with('success', 'Tiket Berhasil dihapus');
        } catch (\Throwable $th) {
            // Log activity
            DB::rollBack();
            return back()->with('error', 'Tiket gagal dihapus');
        }
    }

    // Bagian Komentar

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

            // Notifikasi untuk pengguna dengan peran 'Tenaga Ahli'
            $tenagaAhliUsers = User::role(['SysAdmin', 'DBA'])->get();
            $authenticatedUserName = Auth::user()->name;

            $notificationDataForTenagaAhli = [
                'name' => $authenticatedUserName,
                'body' => 'Ada komentar baru pada tiket anda',
                'thanks' => 'Terimakasih',
                'Text' => 'Tolong cek kembali',
                'Url' => url('/department/assignedTicket/' . $comment->ticket_id),
                'customer_id' => rand(1111, 9999),
                'type' => 'comment',
            ];

            Notification::send($tenagaAhliUsers, new CommentCustomer($notificationDataForTenagaAhli));

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

    public function completedTickets()
    {
        $userId = auth()->user()->id;
        $tickets = Ticket::with('status', 'category', 'priority', 'user_s', 'assignTo', 'statusChangedByUser')
            ->whereHas('user_s', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->where('status_id', 4) // Filter for 'Selesai' status
            ->get();

        return view('dashboard.users.ticket.completed', compact('tickets'));
    }
}
