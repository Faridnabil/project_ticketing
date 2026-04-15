<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Attendance;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs as a timeline.
     */
    public function index(Request $request)
    {
        $hasFilter = $request->hasAny(['user_id', 'tanggal_mulai', 'tanggal_selesai', 'model_type'])
                     || $request->has('page');

        $timeline  = collect();
        $tickets   = collect();
        $paginator = null;

        if ($hasFilter) {
            $query = ActivityLog::with('user');

            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('created_at', '>=', $request->tanggal_mulai);
            }

            if ($request->filled('tanggal_selesai')) {
                $query->whereDate('created_at', '<=', $request->tanggal_selesai);
            }

            $paginator = $query->orderBy('created_at', 'desc')->paginate(50)->withQueryString();
            $logs      = $paginator->getCollection();

            // Resolve no_ticket untuk setiap log pada halaman ini
            $ticketIds = $logs->where('model_type', Ticket::class)->pluck('model_id')->unique();
            $tickets   = Ticket::whereIn('id', $ticketIds)->pluck('no_ticket', 'id');

            // Group by tanggal untuk tampilan timeline
            $timeline = $logs->groupBy(fn($log) => \Carbon\Carbon::parse($log->created_at)->format('d M Y'));
        }

        $users = User::orderBy('name')->get();

        return view('dashboard.admin.activity-log.index', compact('timeline', 'tickets', 'users', 'hasFilter', 'paginator'));
    }

    /**
     * Monitoring aktivitas user per shift.
     */
    public function shiftMonitoring(Request $request)
    {
        $tanggalMulai  = $request->tanggal_mulai  ?? today()->toDateString();
        $tanggalSelesai = $request->tanggal_selesai ?? today()->toDateString();

        $query = Attendance::with('user')
            ->whereDate('date_check_in', '>=', $tanggalMulai)
            ->whereDate('date_check_in', '<=', $tanggalSelesai)
            ->orderBy('date_check_in', 'desc');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->get();

        // Enrich tiap record shift dengan data aktivitas
        foreach ($attendances as $att) {
            $shiftStart = $att->date_check_in;
            $shiftEnd   = $att->date_check_out ?? now();

            $logs = ActivityLog::where('user_id', $att->user_id)
                ->where('model_type', Ticket::class)
                ->whereBetween('created_at', [$shiftStart, $shiftEnd])
                ->get(['model_id']);

            $att->tiket_dikerjakan = $logs->pluck('model_id')->unique()->count();
            $att->total_aktivitas  = $logs->count();
        }

        $users = User::orderBy('name')->get();

        return view('dashboard.admin.activity-log.shift_monitoring', compact(
            'attendances', 'users', 'tanggalMulai', 'tanggalSelesai'
        ));
    }
}
