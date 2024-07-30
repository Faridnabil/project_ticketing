<?php

namespace App\Http\Controllers\Pejabat;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\CityOrRegency;
use App\Models\Comment;
use App\Models\HistoryTicket;
use App\Models\Priority;
use App\Models\Province;
use App\Models\Status;
use App\Models\User;
use App\Notifications\NotificationDepartment;
use App\Notifications\NotificationPejabat;
use App\Notifications\NotificationSiakDev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

class TicketPejabatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with('status', 'category', 'priority', 'pejabat')
            ->where('level5', '!=', null);

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


        $categories = Category::all();
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

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

        //Pindah ke Pejabat
        $PejabatUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Pejabat');
        })->get();

        return view('dashboard.pejabat.ticket.index', compact('tickets', 'categories', 'priorities', 'statuses', 'PejabatUsers', 'levels'));
    }

    public function getCities($provinceId)
    {
        $cities = CityOrRegency::with('province')
            ->where('province_id', $provinceId)
            ->get(['id', 'province_id', 'city_or_regency_name']);

        return response()->json($cities);
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
            'dashboard.pejabat.ticket.show',
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
        $city_or_regencies = CityOrRegency::where('province_id', $ticket->province_id)
            ->get();

        return view(
            'dashboard.pejabat.ticket.edit',
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
            return redirect()->route('pejabat.ticket.index')->with('success', 'Tiket Berhasil Dirubah');
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
            return redirect()->route('pejabat.ticket.index')->with('success', 'Tiket Berhasil dihapus');
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

    public function status_ticket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->status_id = $request->status_id;

        $ticket->save();

        // Notifikasi Ke Pejabat
        if ($request->status_id == 4) {
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket yang ditangani ' . $authenticatedUserName . ', Sudah diselesaikan',
                'thanks' => 'Terimakasih',
                'Text' => '',
                'Url' => url('/pejabat/ticket'),
                'siak_dev_id' => rand(1111, 9999),
            ];

            // Ambil semua pengguna dengan salah satu peran yang disebutkan
            $roles = ['Helpdesk'];
            $helpdesks = User::whereHas('roles', function ($query) use ($roles) {
                $query->whereIn('name', $roles);
            })->get();

            // Kirim notifikasi kepada semua pengguna dengan peran yang disebutkan
            foreach ($helpdesks as $helpdesk) {
                Notification::send($helpdesk, new NotificationSiakDev($notificationData));
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

        return redirect()->back()->with('success', 'Status Tiket telah diubah.');
    }

    public function send_ticket(Request $request, $id)
    {
        // Cari tiket berdasarkan ID
        $ticket = Ticket::findOrFail($id);

        // Update level fields with validated values
        $ticket->level1 = $request->level1;
        $ticket->level2 = $request->level2;
        $ticket->level3 = $request->level3;
        $ticket->level4 = $request->level4;
        $ticket->level5 = $request->level5;

        // Simpan perubahan
        $ticket->save();

        // Notifikasi SIAK Dev
        if ($request->level4) {
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket yang ditangani ' . $authenticatedUserName . ', terlah dialihkan kepada anda',
                'thanks' => 'Terimakasih',
                'Text' => '',
                'Url' => url('/siak-dev/ticket'),
                'pejabat_id' => rand(1111, 9999),
            ];

            // Ambil semua pengguna dengan peran 'admin'
            $helpdesks = User::role('SIAK Dev')
                ->get();

            // Kirim notifikasi kepada semua pengguna dengan peran 'admin'
            foreach ($helpdesks as $helpdesk) {
                Notification::send($helpdesk, new NotificationPejabat($notificationData));
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

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Pengajuan telah dikirim.');
    }

}
