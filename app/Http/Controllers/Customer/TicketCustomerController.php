<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Comment;
use App\Models\HistoryTicket;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use App\Notifications\CommentCustomer;
use App\Notifications\NotificationCustomer;
use Carbon\Carbon;
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

        $assignTo = User::role('Department')
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
            // Generate nomor tiket berdasarkan kategori dan tanggal: CODE-YYYYMMDD-XXX
            $category = Category::find($request->category_id);
            $code = $category ? ($category->code ?? 'TICK') : 'TICK';
            $today = Carbon::now()->format('Ymd');
            $prefix = $code . '-' . $today . '-';

            $lastTicket = Ticket::where('no_ticket', 'LIKE', $prefix . '%')
                ->orderByRaw('CAST(SUBSTR(no_ticket, ' . (strlen($prefix) + 1) . ') AS UNSIGNED) DESC')
                ->first();

            $newTicketIdNumber = $lastTicket ? intval(substr($lastTicket->no_ticket, strlen($prefix))) + 1 : 1;
            $newTicketId = $prefix . str_pad($newTicketIdNumber, 3, '0', STR_PAD_LEFT);

            // Pastikan nomor tiket unik
            while (Ticket::where('no_ticket', $newTicketId)->exists()) {
                $newTicketIdNumber++;
                $newTicketId = $prefix . str_pad($newTicketIdNumber, 3, '0', STR_PAD_LEFT);
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

            //Notifikasi
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

        $assignTo = User::role('Department')
            ->get();

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
                'assignTo',
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

        $assignTo = User::role('Department')
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

            $validate = $request->all();
            $files = $request->file('attachments'); // Mengambil file dari input 'attachments'

            // Ambil file yang dihapus
            $removedAttachments = explode(',', $request->input('removed_attachments'));

            // Ambil file yang masih ada
            $remainingAttachments = explode(',', $request->input('remaining_attachments'));
            $remainingAttachments = array_diff($remainingAttachments, $removedAttachments);

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

            // Gabungkan file baru dengan file yang masih ada
            $attachments = array_merge($remainingAttachments, $attachments);
            $validate['attachments'] = json_encode($attachments);

            // Update tiket dengan data baru
            $ticket->update($validate);

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

            $assignedDepartmentId = $request->assign_to;

            // Notifikasi
            $users = User::role(['Department'])->where('id', $assignedDepartmentId)->get();
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Ada komentar baru pada tiket anda',
                'thanks' => 'Terimakasih',
                'Text' => 'Tolong cek kembali',
                'Url' => url('/department/assignedTicket/' . $comment->ticket_id),
                'customer_id' => rand(1111, 9999),
                'type' => 'comment', // Menambahkan properti 'type'
            ];

            Notification::send($users, new CommentCustomer($notificationData));

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
