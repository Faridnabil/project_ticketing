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
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Regional;
use App\Models\Status;
use App\Models\User;
use App\Notifications\NotificationKoordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class TicketHelpdeskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $query = Ticket::with([
    //         'status', 'category', 'priority', 'helpdesk',
    //         'koordinator', 'staffSubdit', 'siakDev', 'pejabat'
    //     ]);

    //     // Variabel untuk menandai apakah ada filter yang diterapkan
    //     $filtersApplied = false;

    //     // Filter Tanggal
    //     $tanggalMulai = $request->tanggal_mulai;
    //     $tanggalSelesai = $request->tanggal_selesai;

    //     if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
    //         try {
    //             $startDate = Carbon::createFromFormat('Y-m-d', $tanggalMulai)->startOfDay();
    //             $endDate = Carbon::createFromFormat('Y-m-d', $tanggalSelesai)->endOfDay();
    //             $query->whereBetween('tickets.created_at', [$startDate, $endDate]);
    //             $filtersApplied = true;
    //         } catch (\Exception $e) {
    //             return redirect()->back()->withErrors(['Invalid date range provided']);
    //         }
    //     }

    //     // Filter berdasarkan kategori
    //     if ($request->filled('category_id')) {
    //         $query->where('category_id', $request->category_id);
    //         $filtersApplied = true;
    //     }

    //     // Filter berdasarkan level
    //     if ($request->filled('level')) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('level1', $request->level)
    //                 ->orWhere('level2', $request->level)
    //                 ->orWhere('level3', $request->level)
    //                 ->orWhere('level4', $request->level)
    //                 ->orWhere('level5', $request->level);
    //         });
    //         $filtersApplied = true;
    //     }

    //     // Filter berdasarkan prioritas
    //     if ($request->filled('priority_id')) {
    //         $query->where('priority_id', $request->priority_id);
    //         $filtersApplied = true;
    //     }

    //     // Filter berdasarkan status
    //     if ($request->filled('status_id')) {
    //         $query->where('status_id', $request->status_id);
    //         $filtersApplied = true;
    //     }

    //     // Filter berdasarkan provinsi
    //     $provinceId = $request->province_id;
    //     if (!empty($provinceId)) {
    //         $query->where('province_id', $provinceId);
    //         $filtersApplied = true;
    //     }

    //     // Filter berdasarkan kota/kabupaten
    //     if ($request->filled('city_or_regency_id')) {
    //         $query->where('city_or_regency_id', $request->city_or_regency_id);
    //         $filtersApplied = true;
    //     }

    //     // Jika ada filter, ambil datanya. Jika tidak, hasil query dikosongkan.
    //     $tickets = $filtersApplied ? $query->orderByRaw("FIELD(priority_id, '4', '3', '2', '1')")->get() : collect([]);

    //     // Ambil data pendukung lainnya
    //     $categories = Category::all();
    //     $levels = Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get();
    //     $priorities = Priority::all();
    //     $statuses = Status::all();
    //     $koordinatorUsers = Role::where('name', 'Koordinator')->pluck('id')->toArray();
    //     $provinces = Province::all();

    //     // Ambil kota/kabupaten berdasarkan provinsi yang dipilih
    //     $city_or_regencies = !empty($provinceId)
    //         ? CityOrRegency::where('province_id', $provinceId)->get()
    //         : collect([]);

    //     return view('dashboard.helpdesk.ticket.index', [
    //         'tickets' => $tickets,
    //         'provinces' => $provinces,
    //         'city_or_regencies' => $city_or_regencies,
    //         'categories' => $categories,
    //         'priorities' => $priorities,
    //         'statuses' => $statuses,
    //         'levels' => $levels,
    //         'tanggalMulai' => $tanggalMulai,
    //         'tanggalSelesai' => $tanggalSelesai,
    //         'koordinatorUsers' => $koordinatorUsers,
    //         'filter' => $request->all() // Mengirim filter yang digunakan ke view
    //     ]);
    // }

    public function index(Request $request)
    {
        $filtersApplied = false;
        $query = Ticket::with([
            'status', 'category', 'priority', 'helpdesk',
            'koordinator', 'staffSubdit', 'siakDev', 'pejabat'
        ]);

        // Filter Tanggal
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $tanggalMulai)->startOfDay();
                $endDate = Carbon::createFromFormat('Y-m-d', $tanggalSelesai)->endOfDay();
                $query->whereBetween('tickets.created_at', [$startDate, $endDate]);
                $filtersApplied = true;
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['Invalid date range provided']);
            }
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
            $filtersApplied = true;
        }

        if ($request->filled('level')) {
            $query->where(function ($q) use ($request) {
                $q->where('level1', $request->level)
                    ->orWhere('level2', $request->level)
                    ->orWhere('level3', $request->level)
                    ->orWhere('level4', $request->level)
                    ->orWhere('level5', $request->level);
            });
            $filtersApplied = true;
        }

        if ($request->filled('priority_id')) {
            $query->where('priority_id', $request->priority_id);
            $filtersApplied = true;
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
            $filtersApplied = true;
        }

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
            $filtersApplied = true;
        }

        // Build cache key dari filter
        $cacheKey = 'tickets_' . md5(json_encode($request->all()));

        // Ambil dari cache
        if ($filtersApplied) {
            // Jika ada filter, order by priority sesuai urutan 4,3,2,1
            $tickets = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($query) {
                return $query->orderByRaw("FIELD(priority_id, '4', '3', '2', '1')")->get();
            });
        } else {
            // Jika tidak ada filter, ambil tiket terbaru (created_at DESC)
            $tickets = Cache::remember('tickets_latest', now()->addMinutes(30), function () use ($query) {
                return $query->orderBy('created_at', 'desc')->get();
            });
        }

        // Caching data referensi (jika belum dicache)
        $categories = Cache::remember('ticket_categories', now()->addHours(1), fn () => Category::all());
        $levels = Cache::remember('ticket_levels', now()->addHours(1), fn () => Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get());
        $priorities = Cache::remember('ticket_priorities', now()->addHours(1), fn () => Priority::all());
        $statuses = Cache::remember('ticket_statuses', now()->addHours(1), fn () => Status::all());
        $kecamatan = Cache::remember('ticket_kecamatan', now()->addHours(1), fn () => Kecamatan::all());
        $koordinatorUsers = Cache::remember('koordinator_user_ids', now()->addHours(1), fn () =>
            Role::where('name', 'Koordinator')->pluck('id')->toArray()
        );

        // Ambil kota/kabupaten berdasarkan provinsi (jika tersedia)
        $provinceId = $request->province_id ?? null;
        $city_or_regencies = !empty($provinceId)
            ? Cache::remember("cities_by_province_{$provinceId}", now()->addMinutes(30), fn () =>
                CityOrRegency::where('province_id', $provinceId)->get())
            : collect([]);

        return view('dashboard.helpdesk.ticket.index', [
            'tickets' => $tickets,
            'kecamatan' => $kecamatan,
            'categories' => $categories,
            'priorities' => $priorities,
            'statuses' => $statuses,
            'levels' => $levels,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'koordinatorUsers' => $koordinatorUsers,
            'city_or_regencies' => $city_or_regencies,
            'filter' => $request->all()
        ]);
    }





    public function newTicket(Request $request)
    {
        $query = Ticket::with('status', 'category', 'priority', 'helpdesk')
            ->where('level1', '!=', null)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

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

    public function getProvinsi()
    {
        $user = auth()->user();
        $regionalId = $user->regional_id;

        $cacheKey = "provinsi_regional_{$regionalId}";

        $provinsis = Cache::remember($cacheKey, now()->addHours(1), function () use ($regionalId) {
            return Provinsi::select('id', 'code', 'name')
                ->where('regional_id', $regionalId)
                ->orderBy('name')
                ->get();
        });

        return response()->json($provinsis);
    }


    public function getKabupaten()
    {
        $user = auth()->user();
        $provinsiId = $user->provinsi_id;

        $cacheKey = "kabupaten_provinsi_{$provinsiId}";

        $kabupatens = Cache::remember($cacheKey, now()->addHours(1), function () use ($provinsiId) {
            return Kabupaten::select('id', 'code', 'name', 'type')
                ->where('provinsi_id', $provinsiId)
                ->orderBy('name')
                ->get();
        });

        return response()->json($kabupatens);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        // Ambil hanya data sesuai user
        $regionals = Regional::where('id', $user->regional_id)
            ->with(['provinsi' => function ($query) use ($user) {
                $query->where('id', $user->provinsi_id)
                    ->with(['kabupaten' => function ($q) use ($user) {
                        $q->where('id', $user->kabupaten_id);
                    }]);
            }])
            ->get();

        $helpdeskRoles = Role::where('name', 'Helpdesk')
            ->pluck('id')
            ->toArray();

        return view('dashboard.helpdesk.ticket.create', compact(
            'regionals',
            'priorities',
            'statuses',
            'categories',
            'helpdeskRoles',
        ));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category_id' => 'required',
            'status_id' => 'required',
            'priority_id' => 'required',
            'description' => 'required',
            'no_hp' => 'nullable',
            'pic' => 'nullable',
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf'
        ]);
        // dd($request->all());

        DB::beginTransaction();
        try {
            // ===== Generate nomor tiket format TICK-YYYYMMDD-00001 =====
            $today = \Carbon\Carbon::now()->format('Ymd');
            $prefix = 'TICK-' . $today . '-';

            $lastTicket = Ticket::where('no_ticket', 'LIKE', $prefix . '%')
                ->orderByDesc('no_ticket')
                ->first();

            $lastNumber = 0;
            if ($lastTicket) {
                $lastNumber = (int) substr($lastTicket->no_ticket, -5);
            }

            $newTicketNumber = $lastNumber + 1;
            $newTicketId = $prefix . str_pad((string) $newTicketNumber, 5, '0', STR_PAD_LEFT);

            // ==========================================================

            // Ambil semua input yang sudah divalidasi
            $data = $request->all();

            $user = auth()->user();
            $data['regional_id'] = $user->regional_id;
            $data['provinsi_id'] = $user->provinsi_id;
            $data['kabupaten_id'] = $user->kabupaten_id;

            $data['no_ticket'] = $newTicketId;
            $data['level1'] = $request->input('level1');
            $data['pic'] = $request->input('pic ticket');

            // Proses file lampiran jika ada
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $nama_file = time() . "_" . $file->getClientOriginalName();
                    $filePath = $file->storeAs('public/foto/ticket-heldesk', $nama_file);
                    $attachments[] = str_replace('public/', '', $filePath);
                }
            }
            $data['attachments'] = json_encode($attachments);

            // Simpan data tiket
            Ticket::create($data);
            try {
                $http = \Illuminate\Support\Facades\Http::asMultipart();
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $http = $http->attach(
                            'attachments[]',
                            fopen($file->getRealPath(), 'r'),
                            $file->getClientOriginalName()
                        );
                    }
                }
                $http->post('http://82.25.108.179:50000/api/v1/store', [
                    'category_id'   => $data['category_id'] ?? '',
                    'regional_id'   => $data['regional_id'] ?? '',
                    'provinsi_id'   => $data['provinsi_id'] ?? '',
                    'kabupaten_id'  => $data['kabupaten_id'] ?? '',
                    'status_id'     => $data['status_id'] ?? '',
                    'priority_id'   => $data['priority_id'] ?? '',
                    'pic'           => $data['pic'] ?? '',
                    'no_hp'         => $data['no_hp'] ?? '',
                    'description'   => $data['description'] ?? '',
                    'no_ticket'     => $data['no_ticket'] ?? '',
                    'level1'        => $data['level1'] ?? '',
                    'id'            => $user->id ?? '',
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal kirim ke endpoint eksternal: ' . $e->getMessage());
            }
            DB::commit();
            return redirect()->route('helpdesk.newTickets.index')->with('success', 'Tiket Berhasil Dibuat.');
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
        // $provinces = Province::all();
        // $city_or_regencies = CityOrRegency::where('province_id', $ticket->province_id)->get();
        $kecamatan =  Kecamatan::all();


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
                // 'kecamatan'
            )
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket, Request $request)
    {
        if (!session()->has('first_url') || url()->previous() != url()->current()) {
            session(['first_url' => url()->previous()]);
        }

        $user = auth()->user();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        // Ambil hanya data sesuai user
        $regionals = Regional::where('id', $user->regional_id)
            ->with(['provinsi' => function ($query) use ($user) {
                $query->where('id', $user->provinsi_id)
                    ->with(['kabupaten' => function ($q) use ($user) {
                        $q->where('id', $user->kabupaten_id);
                    }]);
            }])
            ->get();

        // Status ID untuk pengecekan logika
        $selesaiStatusId = Status::where('status_name', 'Selesai')->value('id');
        $tertundaStatusId = Status::where('status_name', 'Tertunda')->value('id');
        $diterimaStatusId = Status::where('status_name', 'Diterima')->value('id');
        $bukaKembaliStatusId = Status::where('status_name', 'Buka Kembali')->value('id');

        return view('dashboard.helpdesk.ticket.edit', compact(
            'ticket',
            'priorities',
            'statuses',
            'categories',
            'regionals',
            'selesaiStatusId',
            'tertundaStatusId',
            'diterimaStatusId',
            'bukaKembaliStatusId'
        ));
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $ticket = Ticket::findOrFail($id);

            $request->validate([
                'category_id' => 'required',
                'status_id' => 'required',
                'priority_id' => 'required',
                'description' => 'nullable',
                'no_hp' => 'nullable',
                'pic' => 'nullable',
                'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf'
            ], [
                'attachments.*.mimes' => 'File yang diunggah harus berupa gambar dengan format JPG, JPEG, PNG, atau PDF.',
            ]);

            $data = $request->all();

            // Ambil user dan set ulang regional/prov/kab sesuai user login (mengikuti pola store)
            $user = auth()->user();
            $data['regional_id'] = $user->regional_id;
            $data['provinsi_id'] = $user->provinsi_id;
            $data['kabupaten_id'] = $user->kabupaten_id;

            $data['level1'] = $request->input('level1');
            $data['pic'] = $request->input('pic ticket');

            // File lama
            $existingAttachments = json_decode($ticket->attachments, true) ?? [];

            // File dihapus
            $removedAttachments = explode(',', $request->input('removed_attachments', ''));
            $remainingAttachments = array_diff($existingAttachments, $removedAttachments);

            // File baru
            $newAttachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $nama_file = time() . "_" . $file->getClientOriginalName();
                    $filePath = $file->storeAs('public/foto/ticket-heldesk', $nama_file);
                    $newAttachments[] = str_replace('public/', '', $filePath);
                }
            }

            $data['attachments'] = json_encode(array_merge($remainingAttachments, $newAttachments));

            // Simpan data tiket sebelum diupdate ke tabel history_ticket
            DB::table('history_tickets')->insert([
                'h_no_ticket' => $ticket->no_ticket,
                'h_regional_id' => $ticket->regional_id,
                'h_provinsi_id' => $ticket->provinsi_id,
                'h_kabupaten_id' => $ticket->kabupaten_id,
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

            // Notifikasi jika status "Buka Kembali"
            if ($request->status_id == Status::where('status_name', 'Buka Kembali')->value('id')) {
                $roles = [
                    'Helpdesk' => '/helpdesk/ticket',
                    'Koordinator' => '/koordinator/ticket',
                    'Staff Subdit' => '/staff-subdit/ticket',
                    'SIAK Dev' => '/siak-dev/ticket',
                    'Pejabat' => '/pejabat/ticket',
                ];

                $authUser = Auth::user();
                foreach ($roles as $role => $url) {
                    $users = User::whereHas('roles', fn($q) => $q->where('name', $role))->get();
                    Notification::send($users, new NotificationKoordinator([
                        'name' => $authUser->name,
                        'body' => 'Tiket yang ditangani oleh anda telah dibuka kembali oleh ' . $authUser->name . '. Anda dapat mengecek kembali tiketnya.',
                        'thanks' => 'Terima kasih',
                        'Text' => '',
                        'Url' => url($url),
                        'koordinator_id' => rand(1111, 9999),
                    ]));
                }
            }

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

        // Simpan completion_notes jika status diubah menjadi Selesai
        if ($request->status_id == 4) {
            $ticket->completion_notes = $request->completion_notes;
        }

        $ticket->save();

        // Notifikasi Koordinator
        if ($request->status_id == 4) {
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket yang ditangani ' . $authenticatedUserName . ', Sudah diselesaikan',
                'thanks' => 'Terimakasih',
                'Text' => '',
                'Url' => url('/helpdesk/ticket'),
                'koordinator_id' => rand(1111, 9999),
            ];

            // Ambil semua pengguna dengan salah satu peran yang disebutkan
            $roles = ['Helpdesk'];
            $helpdesks = User::whereHas('roles', function ($query) use ($roles) {
                $query->whereIn('name', $roles);
            })->get();

            // Kirim notifikasi kepada semua pengguna dengan peran yang disebutkan
            foreach ($helpdesks as $helpdesk) {
                Notification::send($helpdesk, new NotificationKoordinator($notificationData));
            }
        }

        // Simpan data tiket sebelum diupdate ke tabel history_ticket
        DB::table('history_tickets')->insert([
            'h_no_ticket' => $ticket->no_ticket,
            'h_regional_id' => $ticket->regional_id,
            'h_provinsi_id' => $ticket->provinsi_id,
            'h_kabupaten_id' => $ticket->kabupaten_id,
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

        // Simpan perubahan
        $ticket->save();

        // Notifikasi Koordinator
        if ($request->level2) {
            $authenticatedUserName = Auth::user()->name;

            $notificationData = [
                'name' => $authenticatedUserName,
                'body' => 'Tiket yang ditangani ' . $authenticatedUserName . ', telah dialihkan kepada anda',
                'thanks' => 'Terimakasih',
                'Text' => '',
                'Url' => url('/koordinator/ticket'),
                'koordinator_id' => rand(1111, 9999),
            ];

            // Ambil semua pengguna dengan peran 'admin'
            $helpdesks = User::role('Koordinator')
                ->get();

            // Kirim notifikasi kepada semua pengguna dengan peran 'admin'
            foreach ($helpdesks as $helpdesk) {
                Notification::send($helpdesk, new NotificationKoordinator($notificationData));
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

    public function getCities($provinceId)
    {
        $cacheKey = 'cities_province_' . $provinceId;

        $cities = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($provinceId) {
            return CityOrRegency::with('province')
                ->where('province_id', $provinceId)
                ->get(['id', 'province_id', 'city_or_regency_name', 'no_city_or_regency']);
        });

        return response()->json($cities);
    }

}
