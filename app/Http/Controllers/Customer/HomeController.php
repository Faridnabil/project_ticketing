<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
{
    $user = Auth::user();

    $tickets = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo', 'statusChangedByUser')
        ->where('customer', $user->id)
        ->get();

    $total_tiket = $tickets->count();
    $tiket_proses = $tickets->where('status.status_name', 'Berlangsung')->count();
    $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
    $tiket_selesai = $tickets->where('status.status_name', 'Tutup')->count();

    return view('dashboard.admin.home.index', compact(
        'tickets', 'total_tiket', 'tiket_proses', 'tiket_tertunda', 'tiket_selesai'
    ));
}

}
