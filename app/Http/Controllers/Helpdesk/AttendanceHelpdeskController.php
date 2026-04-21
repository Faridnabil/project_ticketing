<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceHelpdeskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Attendance::query();

        // Filter
        if ($request->has('check_in') && $request->check_in) {
            $query->where('check_in', $request->check_in);
        }

        if ($request->has('start_date') && $request->start_date) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->where('date_check_in', '>=', $startDate);
        }

        if ($request->has('end_date') && $request->end_date) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->where('date_check_out', '<=', $endDate);
        }

        $attendances = $query->orderBy('created_at', 'desc')->get();

        $attendanceToday = Attendance::where('user_id', Auth::user()->id)
            ->whereDate('date_check_in', now('Asia/Jakarta'))
            ->get();

        // Retrieve all unique check-ins for the form dropdowns
        $allCheckIns = Attendance::select('check_in')->distinct()->pluck('check_in');

        // Menggunakan timezone akurat Asia/Jakarta agar tidak cutoff jam 11 malam
        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $absen = Attendance::where('user_id', Auth::user()->id)
            ->where(function ($query) {
                $query
                    ->where('check_in', 'Shift 1')
                    ->orWhere('check_in', 'Shift 2')
                    ->orWhere('check_in', 'Shift 3');
            })
            ->whereDate('date_check_in', $today)
            ->first();

        return view('dashboard.helpdesk.attendance.index', compact(
            'attendances',
            'attendanceToday',
            'allCheckIns',
            'absen'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.helpdesk.attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            
            // Ambil identifier device browser melalui cookie
            $deviceCookie = $request->cookie('helpdesk_device_id');
            $cookieToSet = null;

            // Validasi 1: Jika User belum mengunci laptop (baru pertama kali absen di sistem yg baru ini)
            if (!$user->assigned_device) {
                // Cek apakah browser ini sudah pernah terikat ke AKUN LAIN
                if ($deviceCookie) {
                    $userOwner = \App\Models\User::where('assigned_device', $deviceCookie)->first();
                    if ($userOwner && $userOwner->id !== $user->id) {
                        return back()->with("error", "Perangkat ini sudah terikat dengan akun rekan anda ({$userOwner->name}). Anda tidak bisa menggunakan laptop ini untuk absen.");
                    }
                }
                
                // Daftarkan browser ini ke akun $user dengan menanam UUID baru
                $newDeviceId = (string) \Illuminate\Support\Str::uuid();
                
                $user->assigned_device = $newDeviceId;
                $user->save(); // Simpan ke tabel users
                
                // Setup cookie permanen 5 tahun di browser
                $cookieToSet = cookie('helpdesk_device_id', $newDeviceId, 60 * 24 * 365 * 5); // 5 tahun
                $deviceCookie = $newDeviceId;
                
            } else {
                // Validasi 2: User sudah mengunci perangkatnya di database.
                // WAJIB menggunakan browser yang menyimpan cookie yang cocok.
                if (!$deviceCookie || $deviceCookie !== $user->assigned_device) {
                    return back()->with("error", "Perangkat/Browser Tidak Valid! Anda hanya dapat melakukan absen menggunakan laptop yang pertama kali Anda daftarkan.");
                }
            }

            // Simpan Data Absen
            $validate = [
                'user_id' => $user->id,
                'name' => $user->name,
                'check_in' => $request->check_in,
                'date_check_in' => now('Asia/Jakarta'),
            ];

            Attendance::create($validate);

            DB::commit();
            
            $response = redirect()->route("helpdesk.attendance.index")->with("success", "Check In berhasil.");
            
            // Jika ada pendaftaran device baru, kirim instruksi penyimpanan cookie ke Browser client
            if ($cookieToSet) {
                $response = $response->cookie($cookieToSet);
            }
            
            return $response;

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", "Check In Gagal: " . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
            ]);

            // Update date_check_out with the provided value
            $attendance->date_check_out = $request->input('date_check_out');
            $attendance->check_out = $request->input('check_out');
            $attendance->activity = $request->input('activity');

            // Handle file upload
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $originalFilename = $file->getClientOriginalName(); // Mendapatkan nama file asli

                // Simpan file di storage/app/public/absen dengan nama asli
                $filePath = $file->storeAs('public/absen', $originalFilename);

                // Simpan path relatif ke storage dengan nama asli ke kolom attachment
                $attendance->attachment = str_replace('public/', '', $filePath); // Path relatif
            }

            $attendance->save();

            DB::commit();
            return redirect()->route("helpdesk.attendance.index")->with("success", "Check Out berhasil.");
        } catch (\Throwable $th) {
            DB::rollBack();
            //    dd($th->getMessage()); // Menampilkan pesan error untuk debugging
            return back()->with("error", 'Check Out Gagal!.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
    public function storeForgotAttendance(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi input dan file
            $request->validate([
                'name' => 'required|string|max:255',
                'check_in' => 'required|string',
                'check_out' => 'required|string',
                'date_check_in' => 'required|date',
                'date_check_out' => 'required|date',
                'activity' => 'nullable|string',
                'user_id' => 'required|integer|exists:users,id',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
            ]);

            // Ambil data dari request
            $data = $request->only([
                'name',
                'check_in',
                'check_out',
                'date_check_in',
                'date_check_out',
                'activity',
                'user_id'
            ]);

            // Set timestamps manual
            $data['created_at'] = $request->date_check_in;
            $data['updated_at'] = $request->date_check_out;

            // Simpan file jika ada
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $originalFilename = $file->getClientOriginalName();
                $filePath = $file->storeAs('public/absen', $originalFilename);
                $data['attachment'] = str_replace('public/', '', $filePath); // path relatif
            }

            // Insert data ke tabel attendance
            Attendance::insert($data); // gunakan insert agar created_at dan updated_at tidak di-override otomatis

            DB::commit();

            return redirect()->route("helpdesk.attendance.index", ['active_tab' => 'lupa_absen'])
                ->with("success", "Check In berhasil.");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", "Check In Gagal, Data Tidak Boleh Kosong atau File Salah.");
        }
    }



}
