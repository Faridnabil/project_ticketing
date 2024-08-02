<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncidentalActivity;
use Illuminate\Support\Facades\Auth;

class IncidentalActivityController extends Controller
{
    public function index()
    {
        $activities = IncidentalActivity::where('user_id', Auth::id())->get();
        return view('dashboard.department.incidental-activities.index', compact('activities'));
    }

    public function create()
    {
        return view('dashboard.department.incidental-activities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:50',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'executor' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'mitigation' => 'required|string',
            'impact' => 'required|string',
            'status' => 'required|string|max:50',
            'file' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('incidental_activities_files', 'public');
        }

        IncidentalActivity::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'executor' => $request->executor,
            'department' => $request->department,
            'mitigation' => $request->mitigation,
            'impact' => $request->impact,
            'status' => $request->status,
            'file_path' => $filePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('department.incidental-activities.index')->with('success', 'Activity added successfully');
    }
}
