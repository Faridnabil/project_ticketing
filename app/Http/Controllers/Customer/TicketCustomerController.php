<?php

namespace App\Http\Controllers\Customer;

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

class TicketCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo')
            ->whereHas('customers', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->get();

        return view('dashboard.customer.ticket.index', compact('tickets'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $customers = User::role('Customer')
            ->where('id', $user->id)
            ->get();

        $assignTo = User::role('Tenaga Ahli')
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        return view(
            'dashboard.customer.ticket.create',
            compact(
                'customers',
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
                'h_customer' => $request->customer,
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
        $customers = User::role('Customer')
            ->get();

        // $assignTo = User::role('Department')
        //     ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $statusChangedBy = Auth::user();

        $logs = HistoryTicket::with('status', 'category', 'priority', 'customers', 'assignTo')
            ->where('h_no_ticket', $ticket->no_ticket)
            ->orderBy('created_at', 'desc')
            ->get();


        $comments = Comment::where('ticket_id', $id)
            ->with('user')
            ->get();

        return view(
            'dashboard.customer.ticket.show',
            compact(
                'ticket',
                'logs',
                'customers',
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

        $customers = User::role('Customer')
            ->get();

        $assignTo = User::role('Tenaga Ahli')
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $statusChangedBy = Auth::user();

        $logs = ActivityLog::where('model_type', Ticket::class)
            ->where('model_id', $ticket->id)
            ->get();

        return view(
            'dashboard.customer.ticket.edit',
            compact(
                'ticket',
                'customers',
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
                'h_customer' => $ticket->customer,
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
            $tenagaAhliUsers = User::role('Tenaga Ahli')->get();
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
        $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo', 'statusChangedByUser')
            ->whereHas('customers', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->where('status_id', 4) // Filter for 'Selesai' status
            ->get();

        return view('dashboard.customer.ticket.completed', compact('tickets'));
    }
}
