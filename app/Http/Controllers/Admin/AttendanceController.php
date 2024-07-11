<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance::all();

        $attendanceToday = Attendance::where('user_id', Auth::user()->id)
            ->whereDate('date_check_in', now())
            ->get();


        return view('dashboard.admin.attendance.index', compact('attendances', 'attendanceToday'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.attendance.create');
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
            $validate['check_in'] = true;

            Attendance::create($validate);

            DB::commit();
            return redirect()->route("attendance.index")->with("success", "Check In berhasil.");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", $th->getMessage());
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
            // Update date_check_out with the current time
            $attendance->date_check_out = now();

            // Handle file uploads
            $files = $request->file('attachment'); // Mengambil file dari input 'attachments'
            $attachments = [];

            if ($files) {
                foreach ($files as $file) {
                    // Proses setiap file
                    $nama_file = time() . "_" . $file->getClientOriginalName();
                    $nama_folder = 'file/absen';
                    $file->move(public_path($nama_folder), $nama_file);
                    $attachments[] = $nama_folder . "/" . $nama_file;
                }
            }

            // Save attachments if needed
            if (!empty($attachments)) {
                $attendance->attachments = json_encode($attachments); // Save as JSON encoded array
            }

            $attendance->save();

            DB::commit();
            return redirect()->route("attendance.index")->with("success", "Check Out berhasil.");
        } catch (\Throwable $th) {
            DB::rollBack();
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
