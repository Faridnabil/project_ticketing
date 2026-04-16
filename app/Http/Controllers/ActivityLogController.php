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
        // Check if there's any filter parameter
        $hasFilter = $request->hasAny(['user_id', 'tanggal_mulai', 'tanggal_selesai', 'model_type', 'model_id', 'attribute', 'drill'])
                     || $request->has('page');

        $timeline  = collect();
        $tickets   = collect();
        $paginator = null;

        if ($hasFilter) {
            $query = ActivityLog::with('user:id,name');

            // If drill=ticket or drill=action and we have user_id + dates, use actual shift time window
            if ($request->filled('drill') && in_array($request->drill, ['ticket', 'action']) && $request->filled('user_id')) {
                // Get the actual shift for this user on this date to use the correct time window
                $tanggalMulai = $request->filled('tanggal_mulai') ? $request->tanggal_mulai : today()->toDateString();

                $attendance = Attendance::where('user_id', $request->user_id)
                    ->whereDate('date_check_in', $tanggalMulai)
                    ->first();

                if ($attendance) {
                    // Use actual shift times instead of just date
                    $shiftStart = $attendance->date_check_in;
                    $shiftEnd = $attendance->date_check_out ?? now();
                    $checkins = $attendance->check_in;

                    $query->where('user_id', $request->user_id)
                          ->whereBetween('created_at', [$shiftStart, $shiftEnd]);

                    // Filter by drill type
                    if ($request->drill === 'ticket') {
                        $query->where(function($q) {
                            $q->where('model_type', Ticket::class)
                              ->orWhere('model_type', 'like', '%Ticket');
                        });
                    }
                    // For 'action' drill, show all activities (no additional model_type filter)
                } else {
                    // If no attendance record found, return empty
                    $paginator = $query->orderBy('created_at', 'desc')->paginate(50)->withQueryString();
                    $logs = collect();
                }
            } else {
                // Standard filtering
                if ($request->filled('user_id')) {
                    $query->where('user_id', $request->user_id);
                }

                if ($request->filled('tanggal_mulai')) {
                    $query->whereDate('created_at', '>=', $request->tanggal_mulai);
                }

                if ($request->filled('tanggal_selesai')) {
                    $query->whereDate('created_at', '<=', $request->tanggal_selesai);
                }

                // Filter by drill parameter (for non-shift case)
                if ($request->filled('drill') && $request->drill === 'ticket') {
                    $query->where(function($q) {
                        $q->where('model_type', Ticket::class)
                          ->orWhere('model_type', 'like', '%Ticket');
                    });
                }

                // Filter by model type and model ID (e.g., specific ticket)
                if (!$request->filled('drill') && $request->filled('model_type')) {
                    $query->where('model_type', $request->model_type);
                    if ($request->filled('model_id')) {
                        $query->where('model_id', $request->model_id);
                    }
                }

                // Filter by attribute (e.g., specific action type)
                if ($request->filled('attribute')) {
                    $query->where('attribute', $request->attribute);
                }
            }

            if (!isset($paginator)) {
                $paginator = $query->orderBy('created_at', 'desc')->paginate(50)->withQueryString();
            }

            $logs = $paginator->getCollection();

            // Resolve no_ticket untuk setiap log pada halaman ini
            $ticketLogs = $logs->filter(function($log) {
                return $log->model_type === Ticket::class || strpos($log->model_type, 'Ticket') !== false;
            });

            $ticketIds = $ticketLogs->pluck('model_id')->unique();
            if ($ticketIds->isNotEmpty()) {
                $tickets = Ticket::whereIn('id', $ticketIds)->pluck('no_ticket', 'id');
            }

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

        // Get attendances with eager load user
        $query = Attendance::with('user')
            ->whereDate('date_check_in', '>=', $tanggalMulai)
            ->whereDate('date_check_in', '<=', $tanggalSelesai)
            ->orderBy('date_check_in', 'desc');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->get();

        // Jika tidak ada attendance, return empty
        if ($attendances->isEmpty()) {
            $users = User::orderBy('name')->get();
            return view('dashboard.admin.activity-log.shift_monitoring', compact(
                'attendances', 'users', 'tanggalMulai', 'tanggalSelesai'
            ));
        }

        // Fetch all activity logs dalam satu query (batch), bukan per-user loop
        // Gunakan created_at agar bisa filter terhadap shift window
        $userIds = $attendances->pluck('user_id')->unique()->toArray();

        $allLogs = ActivityLog::whereIn('user_id', $userIds)
            ->whereBetween('created_at', [
                $attendances->min('date_check_in'),
                now()
            ])
            ->select('id', 'user_id', 'model_type', 'model_id', 'created_at')
            ->get()
            ->groupBy('user_id');

        // Enrich attendance dengan calculated data dari logs yang sudah di-fetch
        foreach ($attendances as $att) {
            $userLogs = $allLogs->get($att->user_id, collect());

            // Filter logs yang jatuh dalam shift window user ini
            $shiftStart = \Carbon\Carbon::parse($att->date_check_in);
            $shiftEnd = $att->date_check_out ? \Carbon\Carbon::parse($att->date_check_out) : now();

            $shiftLogs = $userLogs->filter(function($log) use ($shiftStart, $shiftEnd) {
                $logTime = \Carbon\Carbon::parse($log->created_at);
                return $logTime->between($shiftStart, $shiftEnd);
            });

            // Tiket: hanya count unique ticket IDs dari activities dengan model_type Ticket
            $att->tiket_dikerjakan = $shiftLogs->filter(function($log) {
                return $log->model_type === Ticket::class || strpos($log->model_type, 'Ticket') !== false;
            })->pluck('model_id')->unique()->count();

            // Total aktivitas: semua activities dalam shift
            $att->total_aktivitas = $shiftLogs->count();
        }

        $users = User::orderBy('name')->get();

        return view('dashboard.admin.activity-log.shift_monitoring', compact(
            'attendances', 'users', 'tanggalMulai', 'tanggalSelesai'
        ));
    }
}
