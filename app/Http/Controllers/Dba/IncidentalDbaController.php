<?php

namespace App\Http\Controllers\Dba;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncidentalActivity;
use App\Models\IncidentalActivityCategory;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class IncidentalDbaController extends Controller
{
    public function index()
    {
        $activities = IncidentalActivity::where('user_id', Auth::id())->get();
        $statuses = Status::all();
        $categories = IncidentalActivityCategory::all();

        return view('dashboard.dba.incidental-activities.index', compact('activities', 'statuses', 'categories'));
    }

    public function create()
    {
        $statuses = Status::all();
        $categories = IncidentalActivityCategory::all();
        return view('dashboard.dba.incidental-activities.create', compact('statuses', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:incidental_activity_categories,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'executor' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpg,png,pdf,doc,docx,txt,xlsx,csv|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('incidental_activities_files', 'public');
        }

        // Set status default ke Tertunda
        $statusDefault = Status::where('status_name', 'Tertunda')->first()->id;

        IncidentalActivity::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'executor' => $request->executor,
            'department' => $request->department,
            'status_id' => $statusDefault,
            'file_path' => $filePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dba.incidental-activities.index')
            ->with('success', 'Activity added successfully');
    }


    public function edit($id)
    {
        $activity = IncidentalActivity::findOrFail($id);
        $statuses = Status::all();
        $categories = IncidentalActivityCategory::all();
        return view('dashboard.dba.incidental-activities.edit', compact('activity', 'statuses', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:incidental_activity_categories,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'executor' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'mitigation' => 'required|string',
            'impact' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
            'file' => 'nullable|file|mimes:jpg,png,pdf,doc,docx,txt,xlsx,csv|max:2048',
            'removed_files' => 'nullable|string',
        ]);

        $activity = IncidentalActivity::findOrFail($id);
        $data = $request->only(['title', 'description', 'category_id', 'start_time', 'end_time', 'executor', 'department', 'mitigation', 'impact', 'status_id']);

        // Proses file yang dihapus
        $removedFiles = $request->input('removed_files') ? explode(',', $request->input('removed_files')) : [];
        $existingFiles = $activity->file_path ? json_decode($activity->file_path, true) : [];

        // Pastikan $existingFiles selalu berupa array
        $existingFiles = is_array($existingFiles) ? $existingFiles : [];

        // Filter file yang masih ada setelah penghapusan
        $remainingFiles = array_diff($existingFiles, $removedFiles);

        // Proses file baru yang diupload
        $newFiles = [];
        if ($request->hasFile('file')) {
            $newFilePath = $request->file('file')->store('incidental_activities_files', 'public');
            $newFiles[] = $newFilePath;
        }

        // Gabungkan file baru dengan file yang masih ada
        $allFiles = array_merge($remainingFiles, $newFiles);
        $data['file_path'] = json_encode($allFiles);

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
