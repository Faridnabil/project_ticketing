<?php

namespace App\Http\Controllers\Koordinator;

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
use App\Notifications\NotificationStaffSubdit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cache;

class TicketKoordinatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with('status', 'category', 'priority', 'koordinator')
            ->where('level2', '!=', null);

        if ($request->has('level') && $request->level) {
            $query->where(function ($q) use ($request) {
                $q->where('level1', $request->level)
                    ->orWhere('level2', $request->level)
                    ->orWhere('level3', $request->level)
                    ->orWhere('level4', $request->level)
                    ->orWhere('level5', $request->level);
            });
        }

        // Gunakan cache untuk levels
        $levels = Cache::remember('levels_roles', now()->addMinutes(30), function () {
            return Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get();
        });

        // Gunakan cache untuk categories
        $categories = Cache::remember('ticket_categories', now()->addMinutes(30), function () {
            return Category::all();
        });

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Gunakan cache untuk priorities
        $priorities = Cache::remember('ticket_priorities', now()->addMinutes(30), function () {
            return Priority::all();
        });

        if ($request->has('priority_id') && $request->priority_id) {
            $query->where('priority_id', $request->priority_id);
        }

        // Gunakan cache untuk statuses
        $statuses = Cache::remember('ticket_statuses', now()->addMinutes(30), function () {
            return Status::all();
        });

        if ($request->has('status_id') && $request->status_id) {
            $query->where('status_id', $request->status_id);
        }

        // Filter berdasarkan status_name
        if ($request->has('filter')) {
            $statusesToFilter = explode(',', $request->filter);
            $query->whereHas('status', function ($q) use ($statusesToFilter) {
                $q->whereIn('status_name', $statusesToFilter);
            });
        }

        $tickets = $query->orderBy('id', 'desc')->get();

        // Staff Subdit roles pakai cache juga
        $StaffSubditkRoles = Cache::remember('role_staff_subdit_ids', now()->addMinutes(30), function () {
            return Role::where('name', 'Staff Subdit')->pluck('id')->toArray();
        });

        return view('dashboard.koordinator.ticket.index', compact(
            'tickets',
            'categories',
            'priorities',
            'statuses',
            'StaffSubditkRoles',
            'levels'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!session()->has('filtered_url')) {
            session(['filtered_url' => url()->previous()]);
        }

        // Cache ticket berdasarkan ID
        $ticket = Cache::remember("ticket_{$id}", now()->addMinutes(10), function () use ($id) {
            return Ticket::find($id);
        });

        // Cache priorities, statuses, categories, provinces (statis)
        $priorities = Cache::remember('ticket_priorities', now()->addMinutes(30), function () {
            return Priority::all();
        });

        $statuses = Cache::remember('ticket_statuses', now()->addMinutes(30), function () {
            return Status::all();
        });

        $categories = Cache::remember('ticket_categories', now()->addMinutes(30), function () {
            return Category::all();
        });

        $provinces = Cache::remember('ticket_provinces', now()->addMinutes(30), function () {
            return Province::all();
        });

        // Cache city_or_regencies per province
        $city_or_regencies = Cache::remember("cities_province_{$ticket->province_id}", now()->addMinutes(30), function () use ($ticket) {
            return CityOrRegency::where('province_id', $ticket->province_id)->get();
        });

        // Data yang dinamis seperti logs dan comments sebaiknya tidak di-cache
        $logs = HistoryTicket::with(
                'status',
                'category',
                'priority',
                'helpdesk',
                'koordinator',
                'staffSubdit',
                'siakDev',
                'pejabat',
                'statusChangedBy'
            )
            ->where('h_no_ticket', $ticket->no_ticket)
            ->orderBy('created_at', 'desc')
            ->get();

        $comments = Comment::where('ticket_id', $id)
            ->with('user')
            ->get();

        return view(
            'dashboard.koordinator.ticket.show',
            compact(
                'ticket',
                'logs',
                'priorities',
                'statuses',
                'categories',
                'comments',
                'provinces',
                'city_or_regencies',
            )
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {

        // Simpan URL sebelumnya hanya jika berasal dari halaman indeks
        if (!session()->has('first_url') || url()->previous() != url()->current()) {
            session(['first_url' => url()->previous()]);
        }

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();
        $provinces = Province::all();

        // Fetch the city or regency for the selected province
        $city_or_regencies = CityOrRegency::where('province_id', $ticket->province_id)->get();

        // Dapatkan ID untuk status yang diperlukan
        $selesaiStatusId = Status::where('status_name', 'Selesai')->value('id');
        $tertundaStatusId = Status::where('status_name', 'Tertunda')->value('id');
        $diterimaStatusId = Status::where('status_name', 'Diterima')->value('id');
        $bukaKembaliStatusId = Status::where('status_name', 'Buka Kembali')->value('id');

        $KoordinatorRoles = Role::where('name', 'Koordinator')
            ->pluck('id')
            ->toArray();

        return view(
            'dashboard.koordinator.ticket.edit',
            compact(
                'ticket',
                'priorities',
                'statuses',
                'categories',
                'provinces',
                'city_or_regencies',
                'selesaiStatusId',
                'tertundaStatusId',
                'diterimaStatusId',
                'KoordinatorRoles',
                'bukaKembaliStatusId'
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

            // Validasi request
            $request->validate([
                'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png',
                'removed_attachments' => 'nullable|string'
            ], [
                'attachments.*.mimes' => 'File yang diunggah harus berupa gambar dengan format JPG, JPEG, atau PNG.',
            ]);

            $validate = $request->all();

            // Ambil path lampiran yang ada di database
            $existingAttachments = json_decode($ticket->attachments, true) ?? [];

            // Ambil file yang dihapus dari request
            $removedAttachments = explode(',', $request->input('removed_attachments', ''));
            $remainingAttachments = array_filter($existingAttachments, function ($attachment) use ($removedAttachments) {
                return !in_array(str_replace('storage/', '', $attachment), $removedAttachments);
            });

            $newAttachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $namaFile = time() . "_" . $file->getClientOriginalName();
                    $filePath = $file->storeAs('public/foto/ticket-koordinator', $namaFile);
                    $newAttachments[] = str_replace('public/', '', $filePath);
                }
            }

            // Gabungkan file baru dengan file yang tersisa
            $attachments = array_merge($remainingAttachments, $newAttachments);
            $validate['attachments'] = json_encode($attachments);

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

            // Mengirim Notifikasi (Aktifkan sesuai kebutuhan)
            /*
            $statusId = $validate['status_id'];
            $status = Status::findOrFail($statusId);
            $customerId = $validate['customer'];
            $customer = User::findOrFail($customerId);
            $authenticatedUserName = Auth::user()->name;

            if (in_array($status->status_name, ['Diterima', 'Proses'])) {
                $assignedDepartmentId = $validate['assign_to'];
                $assignedDepartment = User::findOrFail($assignedDepartmentId);

                // Notifikasi untuk Customer
                $notificationDataForCustomer = [
                    'name' => $authenticatedUserName,
                    'body' => 'Tiket anda sudah diterima dan ditugaskan ke departemen: ' . $assignedDepartment->name,
                    'thanks' => 'Terimakasih',
                    'Text' => 'Tolong cek kembali',
                    'Url' => url('/customer/myTicket'),
                ];
                Notification::send($customer, new NotificationCustomer($notificationDataForCustomer));

                // Notifikasi untuk Departemen yang ditugaskan
                $assignedDepartmentUsers = User::role(['Department'])->where('id', $assignedDepartmentId)->get();
                $notificationDataForDepartment = [
                    'name' => $authenticatedUserName,
                    'body' => 'Tiket telah diberikan pada anda untuk dikerjakan',
                    'thanks' => 'Terimakasih',
                    'Text' => 'Tolong cek kembali',
                    'Url' => url('/department/assignedTicket'),
                ];
                Notification::send($assignedDepartmentUsers, new NotificationDepartment($notificationDataForDepartment));
            } elseif ($status->status_name == 'Selesai') {
                $notificationDataForCustomer = [
                    'name' => $authenticatedUserName,
                    'body' => 'Tiket anda sudah dikerjakan',
                    'thanks' => 'Terimakasih',
                    'Text' => 'Tolong cek hasilnya',
                    'Url' => url('/customer/myTicket'),
                ];
                Notification::send($customer, new NotificationCustomer($notificationDataForCustomer));
            }
            */

            // Update tiket dengan data baru
            $ticket->update($validate);

            DB::commit();
            return redirect(session('first_url', route('koordinator.ticket.index')))
                ->with('success', 'Tiket Berhasil Dirubah');
        } catch (\Throwable $th) {
            DB::rollBack();
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
            return redirect()->route('koordinator.ticket.index')->with('success', 'Tiket Berhasil dihapus');
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

        // Simpan completion_notes jika status diubah menjadi Selesai
        if ($request->status_id == 4) {
            $ticket->completion_notes = $request->completion_notes;
        }

        $ticket->save();

        // Notifikasi Staff Subdit
        if ($request->status_id == 4) {
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket yang ditangani ' . $authenticatedUserName . ', Sudah diselesaikan',
                'thanks' => 'Terimakasih',
                'Text' => '',
                'Url' => url('/koordinator/ticket'),
                'staff_subdit_id' => rand(1111, 9999),
            ];

            // Ambil semua pengguna dengan salah satu peran yang disebutkan
            $roles = ['Helpdesk'];
            $helpdesks = User::whereHas('roles', function ($query) use ($roles) {
                $query->whereIn('name', $roles);
            })->get();

            // Kirim notifikasi kepada semua pengguna dengan peran yang disebutkan
            foreach ($helpdesks as $helpdesk) {
                Notification::send($helpdesk, new NotificationStaffSubdit($notificationData));
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
            'h_completion_notes' => $request->status_id == 4 ? $ticket->completion_notes : null,
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
        $ticket->level3 = $request->level3;

        // Simpan perubahan
        $ticket->save();

        // Notifikasi Staff Subdit
        if ($request->level3) {
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket yang ditangani ' . $authenticatedUserName . ', telah dialihkan kepada anda',
                'thanks' => 'Terimakasih',
                'Text' => '',
                'Url' => url('/staff-subdit/ticket'),
                'staff_subdit_id' => rand(1111, 9999),
            ];

            // Ambil semua pengguna dengan peran 'admin'
            $helpdesks = User::role('Staff Subdit')
                ->get();

            // Kirim notifikasi kepada semua pengguna dengan peran 'admin'
            foreach ($helpdesks as $helpdesk) {
                Notification::send($helpdesk, new NotificationStaffSubdit($notificationData));
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
