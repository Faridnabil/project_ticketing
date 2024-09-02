<?php

namespace App\Http\Controllers\Dba;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncidentalActivity;
use App\Models\IncidentalActivityCategory;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class IncidentalDbaController extends Controller
{
    public function index()
    {
        // Ambil semua aktivitas insidental yang terkait dengan user yang sedang login
        $activities = IncidentalActivity::with(['status', 'category']) // Hapus 'users' karena relasi sudah berubah
            ->where('user_id', Auth::id())
            ->get();

        // Ambil semua status dan kategori yang tersedia
        $statuses = Status::all();
        $categories = IncidentalActivityCategory::all();

        // Loop untuk menambahkan daftar pengguna ke setiap aktivitas
        foreach ($activities as $activity) {
            // Ambil daftar pengguna yang terkait dengan aktivitas ini menggunakan method getAssignedUsers()
            $activity->assigned_users = $activity->getAssignedUsers();
        }

        return view('dashboard.dba.incidental-activities.index', compact('activities', 'statuses', 'categories'));
    }

    public function create()
    {
        $statuses = Status::all();
        $categories = IncidentalActivityCategory::all();
        $users = User::role(['SysAdmin', 'DBA'])->get();
        $selectedUsers = [];

        return view('dashboard.dba.incidental-activities.create', compact('statuses', 'categories', 'users', 'selectedUsers'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:incidental_activity_categories,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'users' => 'required|array', // Validate multiple select users
            'mitigation' => 'nullable|string',
            'impact' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'file' => 'nullable|file|mimes:jpg,png,pdf,doc,docx,txt,xlsx,csv|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('incidental_activities_files', 'public');
        }

        // Save incidental activity data and store users as a JSON-encoded array
        $activity = IncidentalActivity::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'mitigation' => $request->mitigation,
            'impact' => $request->impact,
            'status_id' => $request->status_id,
            'file_path' => $filePath,
            'user_id' => Auth::id(),
            'users' => json_encode($request->users), // Store users as a JSON array
        ]);

        return redirect()->route('dba.incidental-activities.index')
            ->with('success', 'Activity added successfully');
    }


    public function edit($id)
    {
        $activity = IncidentalActivity::findOrFail($id);
        $statuses = Status::all();
        $categories = IncidentalActivityCategory::all();
        $users = User::role(['SysAdmin', 'DBA'])->get(); // Ambil pengguna dengan role 'SysAdmin' dan 'DBA'
        $selectedUsers = json_decode($activity->users, true) ?? []; // Decode JSON users dan set default array kosong jika null

        return view('dashboard.dba.incidental-activities.edit', compact('activity', 'statuses', 'categories', 'users', 'selectedUsers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:incidental_activity_categories,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'users' => 'required|array', // Validasi multiple select users
            'mitigation' => 'nullable|string',
            'impact' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'file' => 'nullable|file|mimes:jpg,png,pdf,doc,docx,txt,xlsx,csv|max:2048',
        ]);

        $activity = IncidentalActivity::findOrFail($id);
        $data = $request->only(['title', 'description', 'category_id', 'start_time', 'end_time', 'mitigation', 'impact', 'status_id']);

        // Proses file baru yang diupload
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('incidental_activities_files', 'public');
        }

        // Update aktivitas dan simpan users sebagai JSON
        $data['users'] = json_encode($request->users);
        $activity->update($data);
        return redirect()->route('dba.incidental-activities.index')->with('success', 'Activity updated successfully');
    }


    public function destroy($id)
    {
        $activity = IncidentalActivity::findOrFail($id);
        $activity->delete();

        return redirect()->route('dba.incidental-activities.index')
            ->with('success', 'Incidental Activity deleted successfully.');
    }
}
