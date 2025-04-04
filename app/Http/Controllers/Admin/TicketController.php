<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CityOrRegency;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Comment;
use App\Models\HistoryTicket;
use App\Models\Priority;
use App\Models\Province;
use App\Models\RequestAssignment;
use App\Models\Status;
use App\Models\User;
use App\Notifications\NotificationAdmin;
use App\Notifications\NotificationKoordinator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Cache;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Ticket $ticket)
    {
        $tanggalMulai = $request->tanggal_mulai ?? null;
        $tanggalSelesai = $request->tanggal_selesai ?? null;
        $provinceId = $request->province_id ?? null;

        // Generate cache key yang unik berdasarkan semua filter
        $cacheKey = 'tickets_' . md5(json_encode($request->all()));

        $tickets = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($request, $tanggalMulai, $tanggalSelesai, $provinceId) {
            $query = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat');

            if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
                try {
                    $startDate = Carbon::createFromFormat('Y-m-d', $tanggalMulai)->startOfDay();
                    $endDate = Carbon::createFromFormat('Y-m-d', $tanggalSelesai)->endOfDay();
                    $query->whereBetween('tickets.created_at', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['Invalid date range provided']);
                }
            }

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->filled('level')) {
                $query->where(function ($q) use ($request) {
                    $q->where('level1', $request->level)
                        ->orWhere('level2', $request->level)
                        ->orWhere('level3', $request->level)
                        ->orWhere('level4', $request->level)
                        ->orWhere('level5', $request->level);
                });
            }

            if ($request->filled('priority_id')) {
                $query->where('priority_id', $request->priority_id);
            }

            if ($request->filled('status_id')) {
                $query->where('status_id', $request->status_id);
            }

            if ($provinceId) {
                $query->where('province_id', $provinceId);
            }

            if ($request->filled('city_or_regency_id')) {
                $query->where('city_or_regency_id', $request->city_or_regency_id);
            }

            $query->orderByRaw("FIELD(priority_id, '4', '3', '2', '1')");

            return $query->get();
        });

        // Cache data referensi (opsional juga bisa di-cache)
        $categories = Cache::remember('categories_all', now()->addDay(), fn () => Category::all());
        $priorities = Cache::remember('priorities_all', now()->addDay(), fn () => Priority::all());
        $statuses = Cache::remember('statuses_all', now()->addDay(), fn () => Status::all());
        $levels = Cache::remember('role_levels', now()->addDay(), function () {
            return Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get();
        });

        $koordinatorUsers = Cache::remember('koordinator_user_ids', now()->addDay(), function () {
            return Role::where('name', 'Koordinator')->pluck('id')->toArray();
        });

        $provinces = Cache::remember('provinces_all', now()->addDay(), fn () => Province::all());

        $city_or_regencies = $provinceId
            ? Cache::remember("cities_province_{$provinceId}", now()->addMinutes(30), fn () => CityOrRegency::where('province_id', $provinceId)->get())
            : collect([]);

        return view('dashboard.admin.ticket.index', [
            'tickets' => $tickets,
            'provinces' => $provinces,
            'city_or_regencies' => $city_or_regencies,
            'categories' => $categories,
            'priorities' => $priorities,
            'statuses' => $statuses,
            'levels' => $levels,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'koordinatorUsers' => $koordinatorUsers,
            'filter' => $request->all()
        ]);
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
            'dashboard.admin.ticket.create',
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
            // Ambil nomor tiket terakhir
            $lastTicket = Ticket::where('no_ticket', 'LIKE', 'TICK-%')
                ->orderByRaw('CAST(SUBSTR(no_ticket, 6) AS UNSIGNED) DESC')
                ->first();

            // Generate nomor tiket baru
            $newTicketIdNumber = $lastTicket ? intval(substr($lastTicket->no_ticket, 5)) + 1 : 1;
            $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);

            // Pastikan nomor tiket unik
            while (Ticket::where('no_ticket', $newTicketId)->exists()) {
                $newTicketIdNumber++;
                $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);
            }

            // Ambil semua input yang sudah divalidasi
            $data = $request->all();
            $data['no_ticket'] = $newTicketId;
            $data['level1'] = $request->input('level1'); // Menyimpan role_id jika ada

            // Proses file lampiran jika ada
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $nama_file = time() . "_" . $file->getClientOriginalName();
                    $filePath = $file->storeAs('public/foto/ticket-heldesk', $nama_file);
                    $attachments[] = str_replace('public/', '', $filePath); // Hapus prefix 'public/' agar sesuai dengan URL Storage
                }
            }
            $data['attachments'] = json_encode($attachments);

            // Simpan data tiket
            Ticket::create($data);
            DB::commit();
            return redirect()->route('admin.newTickets.index')->with('success', 'Tiket Berhasil Dibuat.');
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
        if (!session()->has('filtered_url')) {
            session(['filtered_url' => url()->previous()]);
        }

        $ticket = Ticket::find($id);
        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();
        $provinces = Province::all();
        $city_or_regencies = CityOrRegency::where('province_id', $ticket->province_id)->get();


        $logs = HistoryTicket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat', 'statusChangedBy')
            ->where('h_no_ticket', $ticket->no_ticket)
            ->orderBy('created_at', 'desc')
            ->get();


        $comments = Comment::where('ticket_id', $id)
            ->with('user')
            ->get();

        return view(
            'dashboard.admin.ticket.show',
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
    public function edit(Ticket $ticket, Request $request)
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

        return view(
            'dashboard.admin.ticket.edit',
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

            // Validasi input termasuk file lampiran
            $request->validate([
                'category_id' => 'required',
                'province_id' => 'required',
                'city_or_regency_id' => 'required',
                'status_id' => 'required',
                'priority_id' => 'required',
                'pic' => 'required',
                'jabatan' => 'required',
                'no_hp' => 'required',
                'description' => 'required',
                'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png',
            ], [
                'attachments.*.mimes' => 'File yang diunggah harus berupa gambar dengan format JPG, JPEG, atau PNG.',
            ]);

            // Ambil semua input yang sudah divalidasi
            $data = $request->all();

            // Ambil path lampiran yang ada di database jika tidak ada file baru yang diunggah
            $existingAttachments = json_decode($ticket->attachments, true) ?? [];

            // Ambil file yang dihapus dari input (jika ada)
            $removedAttachments = explode(',', $request->input('removed_attachments', ''));
            $remainingAttachments = array_diff($existingAttachments, $removedAttachments);

            // Proses file lampiran baru jika ada
            $newAttachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $nama_file = time() . "_" . $file->getClientOriginalName();
                    // Simpan file ke folder `foto/ticket-helpdesk`
                    $filePath = $file->storeAs('public/foto/ticket-heldesk', $nama_file);

                    // Hapus prefix `public/` agar sesuai dengan yang diinginkan
                    $newAttachments[] = str_replace('public/', '', $filePath);
                }
            }

            // Gabungkan lampiran yang tersisa dan yang baru diunggah
            $data['attachments'] = json_encode(array_merge($remainingAttachments, $newAttachments));

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

            // Notifikasi jika status berubah ke 5
            if ($request->status_id == 5) {
                $roles = [
                    'Helpdesk' => '/helpdesk/ticket',
                    'Koordinator' => '/koordinator/ticket',
                    'Staff Subdit' => '/staff-subdit/ticket',
                    'SIAK Dev' => '/siak-dev/ticket',
                    'Pejabat' => '/pejabat/ticket',
                ];

                $authUser = Auth::user();

                foreach ($roles as $role => $url) {
                    $users = User::whereHas('roles', function ($query) use ($role) {
                        $query->where('name', $role);
                    })->get();

                    $notificationData = [
                        'name' => $authUser->name,
                        'body' => 'Tiket yang ditangani oleh anda telah dibuka kembali oleh ' . $authUser->name . '. Anda dapat mengecek kembali tiketnya.',
                        'thanks' => 'Terima kasih',
                        'Text' => '',
                        'Url' => url($url),
                        'koordinator_id' => rand(1111, 9999),
                    ];

                    Notification::send($users, new NotificationKoordinator($notificationData));
                }
            }

            // Update data tiket dengan data baru
            $ticket->update($data);

            DB::commit();
            return redirect(session('first_url', route('helpdesk.ticket.index')))
            ->with('success', 'Tiket Berhasil Dirubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withInput()->withErrors($th->getMessage());
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
            return redirect()->route('admin.ticket.index')->with('success', 'Tiket Berhasil dihapus');
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
