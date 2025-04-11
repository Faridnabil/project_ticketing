<?php

namespace App\Http\Controllers\SiakDev;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\HistoryTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeSiakDevController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);
        $date = $request->query('selectedDate', now()->toDateString()); // Sinkron dengan input ID selectedDate
        $startTime = $request->query('startTime', '00:00');
        $endTime = $request->query('endTime', '23:59');

        // Konversi waktu berdasarkan tanggal yang dipilih
        $startDateTime = Carbon::parse($date . ' ' . $startTime);
        $endDateTime = Carbon::parse($date . ' ' . $endTime);

        // Query tiket berdasarkan tanggal dan waktu yang dipilih
        $tickets = Cache::remember("siakdev_tickets_{$date}_{$startTime}_{$endTime}", 60, function () use ($startDateTime, $endDateTime) {
            return Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
                ->where('level4', '!=', null)
                ->whereBetween('created_at', [$startDateTime, $endDateTime])
                ->get();
        });

        // Hitung data tiket
        $total_tiket = $tickets->count();
        $tiket_belum = $tickets->where('status.status_name', null)->count();
        $tiket_masuk = $tickets->count() - $tickets->whereIn('status.status_name', ['Selesai', 'Proses', 'Buka Kembali'])->count();
        $tiket_proses = $tickets->whereIn('status.status_name', ['Proses', 'Buka Kembali'])->count();
        $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
        $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();

        // Jika permintaan dari Ajax, kembalikan data sebagai JSON
        if ($request->ajax()) {
            return response()->json([
                'tickets' => $tickets,
                'total_tiket' => $total_tiket,
                'tiket_belum' => $tiket_belum,
                'tiket_masuk' => $tiket_masuk,
                'tiket_proses' => $tiket_proses,
                'tiket_tertunda' => $tiket_tertunda,
                'tiket_selesai' => $tiket_selesai,
            ]);
        }

        return view('dashboard.siak-dev.home.index', compact(
            'tickets',
            'total_tiket',
            'tiket_belum',
            'tiket_masuk',
            'tiket_proses',
            'tiket_tertunda',
            'month',
            'year',
            'tiket_selesai',
            'startTime',
            'endTime',
            'date'
        ));
    }

    public function todaygetTicketChartData(Request $request)
    {
        $selectedDate = $request->input('selectedDate', today()->toDateString());
        $startTime = $request->input('startTime', '00:00');
        $endTime = $request->input('endTime', '23:59');

        // Konversi waktu dan tanggal
        $startTime = Carbon::parse($selectedDate . ' ' . $startTime);
        $endTime = Carbon::parse($selectedDate . ' ' . $endTime);

        // Definisi shift
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

            // Filter tiket
            $ticketsCreated[] = Ticket::whereBetween('created_at', [$shiftStart, $shiftEnd])
                ->where('level4', '!=', null)
                ->whereBetween('created_at', [$startTime, $endTime])
                ->count();
            $ticketsClosed[] = Ticket::where('status_id', 4)
                ->where('level4', '!=', null)
                ->whereBetween('created_at', [$shiftStart, $shiftEnd])
                ->whereBetween('created_at', [$startTime, $endTime])
                ->count();
        }

        return response()->json([
            'ticketsCreated' => $ticketsCreated,
            'ticketsClosed' => $ticketsClosed,
        ]);
    }

    public function indexAll(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year); // Default ke tahun berjalan
        $tickets = Cache::remember("siakdev_all_tickets_{$month}_{$year}", 60, function () use ($month, $year) {
            return Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
                ->when($month && $year, function ($query) use ($month, $year) {
                    $query->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month);
                })
                ->get();
        });

        $total_tiket = $tickets->count();
        $tiket_belum = $tickets->where('status.status_name', null)->count();
        $tiket_masuk = $tickets->count() - $tickets->whereIn('status.status_name', ['Selesai', 'Proses', 'Buka Kembali'])->count();
        $tiket_proses = $tickets->whereIn('status.status_name', ['Proses', 'Buka Kembali'])->count();
        $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
        $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();

        if ($request->ajax()) {
            return response()->json([
                'tickets' => $tickets,
                'total_tiket' => $total_tiket,
                'tiket_belum' => $tiket_belum,
                'tiket_masuk' => $tiket_masuk,
                'tiket_proses' => $tiket_proses,
                'tiket_tertunda' => $tiket_tertunda,
                'tiket_selesai' => $tiket_selesai,
            ]);
        }

        return view('dashboard.siak-dev.home.indexAll', data: compact(
            'tickets',
            'total_tiket',
            'tiket_belum',
            'tiket_masuk',
            'tiket_proses',
            'tiket_tertunda',
            'month',
            'year',
            'tiket_selesai'
        ));
    }

    public function getTicketChartData(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        // Ambil data tiket masuk
        $tickets = Cache::remember("siakdev_chart_tickets_{$year}", 60, function () use ($year) {
            return Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->where('level4', '!=', null)
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->get()
                ->keyBy('month')
                ->toArray();
        });

        // Ambil data tiket selesai
        $ticketsClosed = Cache::remember("siakdev_chart_closed_{$year}", 60, function () use ($year) {
            return Ticket::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
                ->whereYear('updated_at', $year)
                ->where('level4', '!=', null)
                ->where('status_id', 4)
                ->groupBy('month')
                ->get()
                ->keyBy('month')
                ->toArray();
        });

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

        return response()->json($chartData);
    }


    public function getDailyTicketChartData(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $startDate = Carbon::create($year, $month)->startOfMonth();
        $endDate = Carbon::create($year, $month)->endOfMonth();

        $ticketsCreated = Cache::remember("siakdev_daily_created_{$year}_{$month}", 60, function () use ($startDate, $endDate) {
            return Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
                ->where('level4', '!=', null)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('day')
                ->get()
                ->keyBy('day')
                ->toArray();
        });

        $ticketsClosed = Cache::remember("siakdev_daily_closed_{$year}_{$month}", 60, function () use ($startDate, $endDate) {
            return Ticket::selectRaw('DAY(updated_at) as day, COUNT(*) as total')
                ->where('level4', '!=', null)
                ->where('status_id', 4)
                ->whereBetween('updated_at', [$startDate, $endDate])
                ->groupBy('day')
                ->get()
                ->keyBy('day')
                ->toArray();
        });

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

        // Debugging output
        return response()->json($chartData);
    }
}
