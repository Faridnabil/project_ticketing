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

        return view('dashboard.engineer.incidental-activities.index', compact('activities', 'statuses', 'categories'));
    }
}