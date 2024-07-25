<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Comment;
use App\Models\HistoryTicket;
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

class TicketHelpdeskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo');

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

        $tickets = $query->orderBy('id', 'desc')->get();


        // Fetch necessary data for filters
        $level1 = User::role('Helpdesk')
            ->get();
        $level2 = User::role('Koordinator')
            ->get();
        $level3 = User::role('Staff Subdit')
            ->get();
        $level4 = User::role('SIAK Dev')
            ->get();
        $level5 = User::role('Pejabat')
            ->get();
        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        return view('dashboard.helpdesk.ticket.index', compact('tickets', 'categories', 'priorities', 'statuses', 'level1', 'level2', 'level3', 'level4', 'level5'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = User::role('Helpdesk')
            ->get();

        $assignTo = User::role('Koordinator')
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        return view(
            'dashboard.helpdesk.ticket.create',
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

            $validate['attachments'] = json_encode($attachments);

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
        $customers = User::role('Customer')
            ->get();

        $assignTo = User::role('Department')
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $logs = HistoryTicket::with('status', 'category', 'priority', 'customers', 'assignTo')
        ->where('h_no_ticket', $ticket->no_ticket)
        ->orderBy('created_at', 'desc')
        ->get();


        $comments = Comment::where('ticket_id', $id)
            ->with('user')
            ->get();

        return view(
            'dashboard.helpdesk.ticket.show',
            compact(
                'ticket',
                'logs',
                'customers',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
                'comments',
            )
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $customers = User::role('Customer')
            ->get();

        $assignTo = User::role('Department')
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $logs = ActivityLog::where('model_type', Ticket::class)
            ->where('model_id', $ticket->id)
            ->get();

        return view(
            'dashboard.helpdesk.ticket.edit',
            compact(
                'ticket',
                'customers',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
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

            // Simpan data tiket sebelum diupdate ke tabel history_ticket
            DB::table('history_tickets')->insert([
                'h_no_ticket' => $ticket->no_ticket,
                'h_title' => $ticket->title,
                'h_customer' => $ticket->customer,
                'h_assign_to' => $ticket->assign_to,
                'h_priority_id' => $ticket->priority_id,
                'h_due_date' => $ticket->due_date,
                'h_status_id' => $ticket->status_id,
                'h_category_id' => $ticket->category_id,
                'h_description' => $ticket->description,
                'h_attachments' => $ticket->attachments,
                'h_status_changed_by_id' => $ticket->status_changed_by_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ------ Notifikasi --------------
            $statusId = $validate['status_id'];
            $status = Status::findOrFail($statusId); // Asumsikan ada model Status yang memetakan id status ke nama status

            // Ambil customer yang ditugaskan dari inputan
            $customerId = $validate['customer'];
            $customer = User::findOrFail($customerId);

            $authenticatedUserName = Auth::user()->name;

            if (in_array($status->status_name, ['Diterima', 'Proses'])) {
                // Ambil departemen yang ditugaskan dari inputan
                $assignedDepartmentId = $validate['assign_to'];
                $assignedDepartment = User::findOrFail($assignedDepartmentId);

                // Notifikasi untuk Customer
                $notificationDataForCustomer = [
                    'name' => $authenticatedUserName,
                    'body' => 'Tiket anda sudah diterima dan ditugaskan ke departemen: ' . $assignedDepartment->name,
                    'thanks' => 'Terimakasih',
                    'Text' => 'Tolong cek kembali',
                    'Url' => url('/customer/myTicket'),
                    'customer_id' => rand(1111, 9999),
                ];

                Notification::send($customer, new NotificationCustomer($notificationDataForCustomer));

                // Notifikasi untuk Departemen yang ditugaskan
                $assignedDepartmentUsers = User::role(['Department'])->where('id', $assignedDepartmentId)->get();

                $notificationDataForDepartment = [
                    'name' => $authenticatedUserName,
                    'body' => 'Tiket telah diberikan pada anda untuk dikerjakan ',
                    'thanks' => 'Terimakasih',
                    'Text' => 'Tolong cek kembali',
                    'Url' => url('/department/assignedTicket'),
                    'admin_id' => rand(1111, 9999),
                ];

                Notification::send($assignedDepartmentUsers, new NotificationDepartment($notificationDataForDepartment));
            } elseif ($status->status_name == 'Selesai') {
                // Notifikasi untuk Customer bahwa tiket telah dikerjakan
                $notificationDataForCustomer = [
                    'name' => $authenticatedUserName,
                    'body' => 'Tiket anda sudah dikerjakan',
                    'thanks' => 'Terimakasih',
                    'Text' => 'Tolong cek hasilnya',
                    'Url' => url('/customer/myTicket'),
                    'customer_id' => rand(1111, 9999),
                ];

                Notification::send($customer, new NotificationCustomer($notificationDataForCustomer));
            }

            // Gabungkan file baru dengan file yang masih ada
            $attachments = array_merge($remainingAttachments, $attachments);
            $validate['attachments'] = json_encode($attachments);

            // Update tiket dengan data baru
            $ticket->update($validate);

            DB::commit();
            return redirect()->route('ticket.index')->with('success', 'Tiket Berhasil Dirubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage()); // Menampilkan pesan error untuk debugging
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        try {
            if (!$ticket) {
                // Jika principle tidak ditemukan, kembalikan pesan kesalahan
                return back()->with(['error' => 'Tiket Tidak ada.']);
            }

            $ticket->delete(); // Hapus principle
            return redirect()->route('ticket.index')->with('success', 'Tiket Berhasil dihapus');
        } catch (\Throwable $th) {
            // Log activity
            return back()->with('error', 'Tiket gagal dihapus');
        }
    }

    public function store_comment(Request $request)
    {
        DB::beginTransaction();
        try {
            $comment = new Comment();
            $comment->ticket_id = $request->ticket_id;
            $comment->user_id = auth()->id();
            $comment->message = $request->message;
            $comment->created_at = now();
            $comment->updated_at = null;
            $comment->save();

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

    public function approve_assignment(Request $request, RequestAssignment $requestAssignment)
    {
        if (Auth::user()->hasRole('Admin')) {
            $ticket = $requestAssignment->ticket;
            $ticket->assign_to = $requestAssignment->user_id;
            $ticket->save();

            $requestAssignment->status_id = 2; // status_id 2 untuk 'Approved'
            $requestAssignment->save();

            // Notifikasi untuk Departemen yang ditugaskan
            $authenticatedUserName = Auth::user()->name;
            $assignedDepartmentUsers = User::role(['Department'])->where('id', $ticket->assign_to = $requestAssignment->user_id)->get();

            $notificationDataForDepartment = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket yang anda ajukan sudah diterima',
                'thanks' => 'Terimakasih',
                'Text' => 'Tolong cek kembali',
                'Url' => url('/department/assignedTicket'),
                'admin_id' => rand(1111, 9999),
            ];

            Notification::send($assignedDepartmentUsers, new NotificationAdmin($notificationDataForDepartment));


            return redirect()->back()->with('success', 'Tiket berhasil diassign.');
        }

        return redirect()->back()->with('error', 'Anda tidak berhak untuk menyetujui pengajuan ini.');
    }
}
