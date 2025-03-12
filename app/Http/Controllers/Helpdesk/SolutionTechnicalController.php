<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\HistoryTicket;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\CityOrRegency;
use App\Models\Priority;
use App\Models\Province;
use App\Models\Status;
use App\Models\User;
use App\Notifications\NotificationKoordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;


class SolutionTechnicalController extends Controller
{
    public function index(Request $request, Ticket $ticket)
    {
        $query = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
        ->whereNotNull('completion_notes')
        ->where('completion_notes', '!=', '')
        ->orderBy('created_at', 'desc'); // Urutkan berdasarkan created_at terbaru

        // Other filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Retrieve filter data
        $categories = Category::all();
        $levels = Role::whereIn('name', ['Helpdesk', 'Koordinator', 'Staff Subdit', 'SIAK Dev', 'Pejabat'])->get();
        $priorities = Priority::all();
        $statuses = Status::all();

        $tickets = $query->get();

        // Ambil user dengan role Koordinator
        $koordinatorUsers = Role::where('name', 'Koordinator')
            ->pluck('id')
            ->toArray();

        $provinces = Province::all();

        return view('dashboard.helpdesk.solution.index', [
            'tickets' => $tickets,
            'provinces' => $provinces,
            'categories' => $categories,
            'priorities' => $priorities,
            'statuses' => $statuses,
            'levels' => $levels,
            'koordinatorUsers' => $koordinatorUsers,
            'filter' => $request->all() // Kirim filter saat ini ke view
        ]);
    }

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
            'dashboard.helpdesk.solution.edit',
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

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Ambil tiket yang akan diupdate
            $ticket = Ticket::findOrFail($id);

            // Validasi input termasuk file lampiran
            $request->validate([
                'category_id' => 'required',
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
                'h_completion_notes' => $ticket->completion_notes,
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

    public function confirm(Ticket $ticket, Request $request)
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

        $logs = HistoryTicket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat', 'statusChangedBy')
        ->where('h_no_ticket', $ticket->no_ticket)
        ->orderBy('created_at', 'desc')
        ->get();

        return view(
            'dashboard.helpdesk.solution.show',
            compact(
                'logs',
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



}
