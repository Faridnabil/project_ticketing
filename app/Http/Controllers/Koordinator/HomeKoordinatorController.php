<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\HistoryTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeKoordinatorController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);
        $date = $request->query('selectedDate', now()->toDateString());
        $startTime = $request->query('startTime', '00:00');
        $endTime = $request->query('endTime', '23:59');

        $startDateTime = Carbon::parse($date . ' ' . $startTime);
        $endDateTime = Carbon::parse($date . ' ' . $endTime);

        // Gunakan cache
        $cacheKey = "tickets_{$date}_{$startTime}_{$endTime}";
        $tickets = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($startDateTime, $endDateTime) {
            return Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
                ->where('level2', '!=', null)
                ->whereBetween('created_at', [$startDateTime, $endDateTime])
                ->get();
        });

        $total_tiket = $tickets->count();
        $tiket_belum = $tickets->where('status.status_name', null)->count();
        $tiket_masuk = $tickets->count() - $tickets->whereIn('status.status_name', ['Selesai', 'Proses', 'Buka Kembali'])->count();
        $tiket_proses = $tickets->whereIn('status.status_name', ['Proses', 'Buka Kembali'])->count();
        $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
        $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();

        if ($request->ajax()) {
            return response()->json(compact(
                'tickets', 'total_tiket', 'tiket_belum', 'tiket_masuk', 'tiket_proses', 'tiket_tertunda', 'tiket_selesai'
            ));
        }

        return view('dashboard.koordinator.home.index', compact(
            'tickets', 'total_tiket', 'tiket_belum', 'tiket_masuk', 'tiket_proses',
            'tiket_tertunda', 'month', 'year', 'tiket_selesai', 'startTime', 'endTime', 'date'
        ));
    }

    public function todaygetTicketChartData(Request $request)
    {
        $selectedDate = $request->input('selectedDate', today()->toDateString());
        $startTime = $request->input('startTime', '00:00');
        $endTime = $request->input('endTime', '23:59');

        $startTimeParsed = Carbon::parse($selectedDate . ' ' . $startTime);
        $endTimeParsed = Carbon::parse($selectedDate . ' ' . $endTime);

        $cacheKey = "today_chart_{$selectedDate}_{$startTime}_{$endTime}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($selectedDate, $startTimeParsed, $endTimeParsed) {
            $shifts = [
                'shift1' => ['07:00:00', '15:00:00'],
                'shift2' => ['15:00:00', '23:00:00'],
                'shift3' => ['23:00:00', '07:00:00'],
            ];

            $ticketsCreated = [];
            $ticketsClosed = [];

            foreach ($shifts as $shift => [$startShift, $endShift]) {
                $shiftStart = Carbon::parse($selectedDate . ' ' . $startShift);
                $shiftEnd = $shift === 'shift3'
                    ? Carbon::parse($selectedDate . ' ' . $endShift)->addDay()
                    : Carbon::parse($selectedDate . ' ' . $endShift);

                $ticketsCreated[] = Ticket::whereBetween('created_at', [$shiftStart, $shiftEnd])
                    ->where('level2', '!=', null)
                    ->whereBetween('created_at', [$startTimeParsed, $endTimeParsed])
                    ->count();

                $ticketsClosed[] = Ticket::where('status_id', 4)
                    ->where('level2', '!=', null)
                    ->whereBetween('created_at', [$shiftStart, $shiftEnd])
                    ->whereBetween('created_at', [$startTimeParsed, $endTimeParsed])
                    ->count();
            }

            return [
                'ticketsCreated' => $ticketsCreated,
                'ticketsClosed' => $ticketsClosed,
            ];
        });
    }

    public function indexAll(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);
        $cacheKey = "tickets_all_{$month}_{$year}";

        $tickets = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($month, $year) {
            return Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();
        });

        $total_tiket = $tickets->count();
        $tiket_belum = $tickets->where('status.status_name', null)->count();
        $tiket_masuk = $tickets->count() - $tickets->whereIn('status.status_name', ['Selesai', 'Proses', 'Buka Kembali'])->count();
        $tiket_proses = $tickets->whereIn('status.status_name', ['Proses', 'Buka Kembali'])->count();
        $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
        $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();

        if ($request->ajax()) {
            return response()->json(compact(
                'tickets', 'total_tiket', 'tiket_belum', 'tiket_masuk', 'tiket_proses', 'tiket_tertunda', 'tiket_selesai'
            ));
        }

        return view('dashboard.koordinator.home.indexAll', compact(
            'tickets', 'total_tiket', 'tiket_belum', 'tiket_masuk', 'tiket_proses', 'tiket_tertunda', 'month', 'year', 'tiket_selesai'
        ));
    }

    public function getTicketChartData(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $cacheKey = "chart_data_year_{$year}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($year) {
            $tickets = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->get()
                ->keyBy('month')
                ->toArray();

            $ticketsClosed = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->where('status_id', 4)
                ->groupBy('month')
                ->get()
                ->keyBy('month')
                ->toArray();

            $chartData = [
                'months' => [],
                'tickets' => [],
                'ticketsClosed' => []
            ];

            for ($i = 1; $i <= 12; $i++) {
                $chartData['months'][] = Carbon::create()->month($i)->format('F');
                $chartData['tickets'][] = $tickets[$i]['total'] ?? 0;
                $chartData['ticketsClosed'][] = $ticketsClosed[$i]['total'] ?? 0;
            }

            return $chartData;
        });
    }

    public function getDailyTicketChartData(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $cacheKey = "daily_chart_{$year}_{$month}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($month, $year) {
            $startDate = Carbon::create($year, $month)->startOfMonth();
            $endDate = Carbon::create($year, $month)->endOfMonth();

            $ticketsCreated = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('day')
                ->get()
                ->keyBy('day')
                ->toArray();

            $ticketsClosed = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
                ->where('status_id', 4)
                ->whereYear('created_at', $year)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('day')
                ->get()
                ->keyBy('day')
                ->toArray();

            $chartData = [
                'days' => [],
                'ticketsCreated' => [],
                'ticketsClosed' => []
            ];

            for ($i = 1; $i <= $endDate->day; $i++) {
                $chartData['days'][] = $i;
                $chartData['ticketsCreated'][] = $ticketsCreated[$i]['total'] ?? 0;
                $chartData['ticketsClosed'][] = $ticketsClosed[$i]['total'] ?? 0;
            }

            return $chartData;
        });
    }
}

