<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\CityOrRegency;
use App\Models\Comment;
use App\Models\HistoryTicket;
use App\Models\Priority;
use App\Models\Province;
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
use Spatie\Permission\Models\Role;

class TicketHelpdeskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with('status', 'category', 'priority', 'helpdesk');

        $categories = Category::all();
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('level') && $request->level) {
            $query->where(function ($q) use ($request) {
                $q->where('level1', $request->level)
                    ->orWhere('level2', $request->level)
                    ->orWhere('level3', $request->level)
                    ->orWhere('level4', $request->level)
                    ->orWhere('level5', $request->level);
            });
        }

        // Ambil data untuk filter level dari tabel Role
        $levels = Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get();



        $priorities = Priority::all();
        if ($request->has('priority_id') && $request->priority_id) {
            $query->where('priority_id', $request->priority_id);
        }

        $statuses = Status::all();
        if ($request->has('status_id') && $request->status_id) {
            $query->where('status_id', $request->status_id);
        }

        $tickets = $query->orderBy('id', 'desc')
            ->get();

        // Ambil user dengan role Koordinator
        $koordinatorUsers = Role::where('name', 'Koordinator')
            ->pluck('id')
            ->toArray();
        return view('dashboard.helpdesk.ticket.index', compact('tickets', 'categories', 'priorities', 'statuses', 'koordinatorUsers', 'levels'));
    }

    public function NewTicket(Request $request)
    {
        $query = Ticket::with('status', 'category', 'priority', 'helpdesk')
            ->where('level1', '!=', null);

        $categories = Category::all();
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('level') && $request->level) {
            $query->where(function ($q) use ($request) {
                $q->where('level1', $request->level)
                    ->orWhere('level2', $request->level)
                    ->orWhere('level3', $request->level)
                    ->orWhere('level4', $request->level)
                    ->orWhere('level5', $request->level);
            });
        }

        $levels = Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get();

        $priorities = Priority::all();
        if ($request->has('priority_id') && $request->priority_id) {
            $query->where('priority_id', $request->priority_id);
        }

        $statuses = Status::all();
        if ($request->has('status_id') && $request->status_id) {
            $query->where('status_id', $request->status_id);
        }

        $tickets = $query->orderBy('id', 'desc')->get();

        $koordinatorUsers = Role::where('name', 'Koordinator')->pluck('id')->toArray();

        return view('dashboard.helpdesk.ticket.new_ticket', compact('tickets', 'categories', 'priorities', 'statuses', 'koordinatorUsers', 'levels'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();
        $provinces = Province::all();

        $city_or_regencies = CityOrRegency::with('province');

        //Pindah ke Staff Subdit
        $helpdeskRoles = Role::where('name', 'Helpdesk')
            ->pluck('id')
            ->toArray();

        return view(
            'dashboard.helpdesk.ticket.create',
            compact(
                'city_or_regencies',
                'provinces',
                'priorities',
                'statuses',
                'categories',
                'helpdeskRoles',
            )
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'province_id' => 'required',
            'city_or_regency_id' => 'required',
            'status_id' => 'required',
            'priority_id' => 'required',
            'pic' => 'required',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'description' => 'required'
        ]);

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
            $validate['level1'] = $request->input('level1'); // Menyimpan role_id

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

            // Simpan data tiket sebelum diupdate ke tabel history_ticket
            // DB::table('history_tickets')->insert([
            //     'h_no_ticket' => $request->no_ticket,
            //     'h_province_id' => $request->province_id,
            //     'h_city_or_regency_id' => $request->city_or_regency_id,
            //     'h_level1' => $request->level1,
            //     'h_level2' => $request->level2,
            //     'h_level3' => $request->level3,
            //     'h_level4' => $request->level4,
            //     'h_level5' => $request->level5,
            //     'h_priority_id' => $request->priority_id,
            //     'h_status_id' => $request->status_id,
            //     'h_category_id' => $request->category_id,
            //     'h_description' => $request->description,
            //     'h_attachments' => $request->attachments ?? null,
            //     'h_pic' => $request->pic,
            //     'h_jabatan' => $request->jabatan,
            //     'h_no_hp' => $request->no_hp,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            //     'status_changedBy' => Auth::user()->id,
            // ]);

            DB::commit();
            return redirect()->route('helpdesk.NewTicket.index')->with('success', 'Tiket Berhasil Dibuat.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withInput()->withErrors($th->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $logs = HistoryTicket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat', 'statusChangedBy')
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
        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();
        $provinces = Province::all();

        // Fetch the city or regency for the selected province
        $city_or_regencies = CityOrRegency::where('province_id', $ticket->province_id)->get();

        return view(
            'dashboard.helpdesk.ticket.edit',
            compact(
                'ticket',
                'priorities',
                'statuses',
                'categories',
                'provinces',
                'city_or_regencies'
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
                'h_province_id' => $ticket->province_id,
                'h_city_or_regency_id' => $ticket->city_or_regency_id,
                'h_level1' => $ticket->level1,
                'h_level2' => $ticket->level2,
                'h_level3' => $ticket->level3,
                'h_level4' => $ticket->level4,
                'h_level5' => $ticket->level5,
                'h_priority_id' => $ticket->priority_id,
                'h_status_id' => $ticket->status_id,
                'h_category_id' => $ticket->category_id,
                'h_description' => $ticket->description,
                'h_attachments' => $ticket->attachments,
                'h_pic' => $ticket->pic,
                'h_jabatan' => $ticket->jabatan,
                'h_no_hp' => $ticket->no_hp,
                'created_at' => now(),
                'updated_at' => now(),
                'status_changedBy' => Auth::user()->id,
            ]);

            // ------ Notifikasi --------------
            // $statusId = $validate['status_id'];
            // $status = Status::findOrFail($statusId); // Asumsikan ada model Status yang memetakan id status ke nama status

            // // Ambil customer yang ditugaskan dari inputan
            // $customerId = $validate['customer'];
            // $customer = User::findOrFail($customerId);

            // $authenticatedUserName = Auth::user()->name;

            // if (in_array($status->status_name, ['Diterima', 'Proses'])) {
            //     // Ambil departemen yang ditugaskan dari inputan
            //     $assignedDepartmentId = $validate['assign_to'];
            //     $assignedDepartment = User::findOrFail($assignedDepartmentId);

            //     // Notifikasi untuk Customer
            //     $notificationDataForCustomer = [
            //         'name' => $authenticatedUserName,
            //         'body' => 'Tiket anda sudah diterima dan ditugaskan ke departemen: ' . $assignedDepartment->name,
            //         'thanks' => 'Terimakasih',
            //         'Text' => 'Tolong cek kembali',
            //         'Url' => url('/customer/myTicket'),
            //         'customer_id' => rand(1111, 9999),
            //     ];

            //     Notification::send($customer, new NotificationCustomer($notificationDataForCustomer));

            //     // Notifikasi untuk Departemen yang ditugaskan
            //     $assignedDepartmentUsers = User::role(['Department'])->where('id', $assignedDepartmentId)->get();

            //     $notificationDataForDepartment = [
            //         'name' => $authenticatedUserName,
            //         'body' => 'Tiket telah diberikan pada anda untuk dikerjakan ',
            //         'thanks' => 'Terimakasih',
            //         'Text' => 'Tolong cek kembali',
            //         'Url' => url('/department/assignedTicket'),
            //         'admin_id' => rand(1111, 9999),
            //     ];

            //     Notification::send($assignedDepartmentUsers, new NotificationDepartment($notificationDataForDepartment));
            // } elseif ($status->status_name == 'Selesai') {
            //     // Notifikasi untuk Customer bahwa tiket telah dikerjakan
            //     $notificationDataForCustomer = [
            //         'name' => $authenticatedUserName,
            //         'body' => 'Tiket anda sudah dikerjakan',
            //         'thanks' => 'Terimakasih',
            //         'Text' => 'Tolong cek hasilnya',
            //         'Url' => url('/customer/myTicket'),
            //         'customer_id' => rand(1111, 9999),
            //     ];

            //     Notification::send($customer, new NotificationCustomer($notificationDataForCustomer));
            // }

            // Gabungkan file baru dengan file yang masih ada
            $attachments = array_merge($remainingAttachments, $attachments);
            $validate['attachments'] = json_encode($attachments);

            // Update tiket dengan data baru
            $ticket->update($validate);

            DB::commit();
            return redirect()->route('helpdesk.ticket.index')->with('success', 'Tiket Berhasil Dirubah');
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
            return redirect()->route('helpdesk.ticket.index')->with('success', 'Tiket Berhasil dihapus');
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

    // public function approve_assignment(Request $request, RequestAssignment $requestAssignment)
    // {
    //     if (Auth::user()->hasRole('Admin')) {
    //         $ticket = $requestAssignment->ticket;
    //         $ticket->assign_to = $requestAssignment->user_id;
    //         $ticket->save();

    //         $requestAssignment->status_id = 2; // status_id 2 untuk 'Approved'
    //         $requestAssignment->save();

    //         // Notifikasi untuk Departemen yang ditugaskan
    //         $authenticatedUserName = Auth::user()->name;
    //         $assignedDepartmentUsers = User::role(['Department'])->where('id', $ticket->assign_to = $requestAssignment->user_id)->get();

    //         $notificationDataForDepartment = [
    //             'name' => $authenticatedUserName,
    //             'body' => 'Tiket yang anda ajukan sudah diterima',
    //             'thanks' => 'Terimakasih',
    //             'Text' => 'Tolong cek kembali',
    //             'Url' => url('/department/assignedTicket'),
    //             'admin_id' => rand(1111, 9999),
    //         ];

    //         Notification::send($assignedDepartmentUsers, new NotificationAdmin($notificationDataForDepartment));


    //         return redirect()->back()->with('success', 'Tiket berhasil diassign.');
    //     }

    //     return redirect()->back()->with('error', 'Anda tidak berhak untuk menyetujui pengajuan ini.');
    // }

    public function status_ticket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->status_id = $request->status_id;
        // $ticket->status_id = null;
        // $ticket->approval_assign_to = 0;

        // Simpan status_id yang lama sebelum mengubahnya
        // $oldStatusId = $ticket->status_id;

        // Update status_id dengan yang baru dari request

        // Periksa apakah status_id berubah menjadi 4
        // if ($request->status_id == 4) {
        //     $authenticatedUserName = Auth::user()->name;

        //     $notificationData = [
        //         'name' => $authenticatedUserName,
        //         'body' => 'Tiket yang ditangani oleh ' . $authenticatedUserName . ', sudah terselesaikan',
        //         'thanks' => 'Terimakasih',
        //         'Text' => '',
        //         'Url' => url('/admin/ticket'),
        //         'customer_id' => rand(1111, 9999),
        //     ];

        //     // Ambil semua pengguna dengan peran 'admin'
        //     $helpdesks = User::role('Helpdesk')
        //         ->get();

        //     // Kirim notifikasi kepada semua pengguna dengan peran 'admin'
        //     foreach ($helpdesks as $helpdesk) {
        //         Notification::send($helpdesk, new NotificationDepartment($notificationData));
        //     }
        // }

        $ticket->save();

        // Simpan data tiket sebelum diupdate ke tabel history_ticket
        DB::table('history_tickets')->insert([
            'h_no_ticket' => $ticket->no_ticket,
            'h_province_id' => $ticket->province_id,
            'h_city_or_regency_id' => $ticket->city_or_regency_id,
            'h_level1' => $ticket->level1,
            'h_level2' => $ticket->level2,
            'h_level3' => $ticket->level3,
            'h_level4' => $ticket->level4,
            'h_level5' => $ticket->level5,
            'h_priority_id' => $ticket->priority_id,
            'h_status_id' => $ticket->status_id,
            'h_category_id' => $ticket->category_id,
            'h_description' => $ticket->description,
            'h_attachments' => $ticket->attachments,
            'h_pic' => $ticket->pic,
            'h_jabatan' => $ticket->jabatan,
            'h_no_hp' => $ticket->no_hp,
            'created_at' => now(),
            'updated_at' => now(),
            'status_changedBy' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Status Tiket telah diubah.');
    }

    public function send_ticket(Request $request, $id)
    {
        // Cari tiket berdasarkan ID
        $ticket = Ticket::findOrFail($id);

        // Update level2 dengan nilai dari request
        $ticket->level1 = $request->level1;
        $ticket->level2 = $request->level2;


        // Simpan perubahan
        $ticket->save();

        // Simpan data tiket sebelum diupdate ke tabel history_ticket
        DB::table('history_tickets')->insert([
            'h_no_ticket' => $ticket->no_ticket,
            'h_province_id' => $ticket->province_id,
            'h_city_or_regency_id' => $ticket->city_or_regency_id,
            'h_level1' => $ticket->level1,
            'h_level2' => $ticket->level2,
            'h_level3' => $ticket->level3,
            'h_level4' => $ticket->level4,
            'h_level5' => $ticket->level5,
            'h_priority_id' => $ticket->priority_id,
            'h_status_id' => $ticket->status_id,
            'h_category_id' => $ticket->category_id,
            'h_description' => $ticket->description,
            'h_attachments' => $ticket->attachments,
            'h_pic' => $ticket->pic,
            'h_jabatan' => $ticket->jabatan,
            'h_no_hp' => $ticket->no_hp,
            'created_at' => now(),
            'updated_at' => now(),
            'status_changedBy' => Auth::user()->id,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Pengajuan telah dikirim.');
    }
    public function getCities($provinceId)
    {
        $cities = CityOrRegency::with('province')
            ->where('province_id', $provinceId)
            ->get(['id', 'province_id', 'city_or_regency_name']);

        return response()->json($cities);
    }
}
