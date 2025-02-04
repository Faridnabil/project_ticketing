<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\CityOrRegency;
use App\Models\Priority;
use App\Models\Province;
use App\Models\Status;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class SolutionTechnicalController extends Controller
{
    public function index(Request $request, Ticket $ticket)
    {
        $query = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
        ->whereNotNull('completion_notes')
        ->where('completion_notes', '!=', '');

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

}
