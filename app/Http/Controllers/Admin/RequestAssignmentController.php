<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestAssignment;
use Illuminate\Http\Request;

class RequestAssignmentController extends Controller
{
    public function index()
    {
        // Ambil semua request assignments dengan status pending
        $requestAssignments = RequestAssignment::where('status_id', 1)
            ->get();

        return view('dashboard.admin.request-assignment.index', compact('requestAssignments'));
    }
}
