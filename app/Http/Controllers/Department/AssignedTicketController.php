<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
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
use App\Notifications\NotificationDepartment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AssignedTicketController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo')
            ->whereHas('assignTo', function ($query) use ($userId) {
                $query->where('id', $userId); // Menggunakan 'id' karena 'user_id' adalah primary key di tabel 'users'
            })
            ->get();

        $users = User::role('Helpdesk')
            ->where('id', '!=', Auth::user()->id)
            ->get();


        return view('dashboard.helpdesk.assigned-ticket.index', compact('tickets', 'users'));
    }

    public function show($id)
    {
        $ticket = Ticket::find($id);
        $customers = User::role('Customer')
            ->get();

        $assignTo = User::role('Helpdesk')
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
            'dashboard.helpdesk.assigned-ticket.show',
            compact(
                'ticket',
                'logs',
                'customers',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
                'comments'
            )
        );
    }

    public function edit($id)
    {
        $ticket = Ticket::find($id);
        $customers = User::role('Customer')->get();
        $assignTo = User::role('Helpdesk')->get();
        $priorities = Priority::all();
        $statuses = Status::where('status_name', '!=', 'Tertunda')->get();
        $categories = Category::all();
        $logs = ActivityLog::where('model_type', Ticket::class)
            ->where('model_id', $ticket->id)
            ->get();

        return view(
            'dashboard.helpdesk.assigned-ticket.edit',
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

            $oldNoTicket = $ticket->no_ticket;
            if (isset($request->category_id) && $ticket->category_id != $request->category_id) {
                $category = \App\Models\Category::find($request->category_id);
                $code = $category ? ($category->code ?? 'TICK') : 'TICK';
                
                $ticketDate = $ticket->created_at ? $ticket->created_at->format('Ymd') : \Carbon\Carbon::now()->format('Ymd');
                $prefix = $code . '-' . $ticketDate . '-';

                $lastTicket = Ticket::where('no_ticket', 'LIKE', $prefix . '%')
                    ->orderByRaw('CAST(SUBSTR(no_ticket, ' . (strlen($prefix) + 1) . ') AS UNSIGNED) DESC')
                    ->first();

                $newTicketIdNumber = $lastTicket ? intval(substr($lastTicket->no_ticket, strlen($prefix))) + 1 : 1;
                $newTicketId = $prefix . str_pad($newTicketIdNumber, 3, '0', STR_PAD_LEFT);

                while (Ticket::where('no_ticket', $newTicketId)->exists()) {
                    $newTicketIdNumber++;
                    $newTicketId = $prefix . str_pad($newTicketIdNumber, 3, '0', STR_PAD_LEFT);
                }

                $validate['no_ticket'] = $newTicketId;
            }

            // Simpan data tiket sebelum diupdate ke tabel history_ticket
            DB::table('history_tickets')->insert([
                'h_no_ticket' => isset($validate['no_ticket']) ? $validate['no_ticket'] : $ticket->no_ticket,
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

            if (isset($validate['no_ticket']) && $validate['no_ticket'] != $oldNoTicket) {
                // Update history agar histori yang lama tetap terkait dengan tiket ini
                DB::table('history_tickets')->where('h_no_ticket', $oldNoTicket)->update(['h_no_ticket' => $validate['no_ticket']]);
            }

            DB::commit();
            return redirect()->route('assignedTicket.index')->with('success', 'Tiket Berhasil Dirubah');
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
