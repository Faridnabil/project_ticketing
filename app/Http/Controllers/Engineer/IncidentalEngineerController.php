<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncidentalActivity;
use App\Models\IncidentalActivityCategory;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class IncidentalEngineerController extends Controller
{
    public function index()
    {
        $activities = IncidentalActivity::all();
        $statuses = Status::all();
        $categories = IncidentalActivityCategory::all();
        foreach ($activities as $activity) {
            // Ambil daftar pengguna yang terkait dengan aktivitas ini menggunakan method getAssignedUsers()
            $activity->assigned_users = $activity->getAssignedUsers();
        }

        return view('dashboard.engineer.incidental-activities.index', compact('activities', 'statuses', 'categories'));
    }

    public function show($id)
    {
        // Ambil data aktivitas insidental berdasarkan ID yang diterima
        $activity = IncidentalActivity::with(['category', 'status'])
            ->findOrFail($id);

        // Ambil daftar pengguna assigned menggunakan method getAssignedUsers()
        $assigned_users = $activity->getAssignedUsers();

        // Kirim data ke view show/detail
        return view('dashboard.engineer.incidental-activities.show', compact('activity', 'assigned_users'));
    }
}
