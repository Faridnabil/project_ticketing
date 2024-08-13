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

        $attendances = $query->get();

        $attendanceToday = Attendance::where('user_id', Auth::user()->id)
            ->whereDate('date_check_in', now())
            ->get();

        // Retrieve all unique check-ins for the form dropdowns
        $allCheckIns = Attendance::select('check_in')->distinct()->pluck('check_in');

        return view('dashboard.helpdesk.attendance.index', compact('attendances', 'attendanceToday', 'allCheckIns'));
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

            $validate = $request->all();
            $validate['date_check_in'] = now();

            Attendance::create($validate);

            DB::commit();
            return redirect()->route("helpdesk.attendance.index")->with("success", "Check In berhasil.");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", "Check In Gagal, Data Tidak Boleh Kosong");
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
            return back()->with("error", $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
