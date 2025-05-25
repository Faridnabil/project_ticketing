<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Regional;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeHelpdeskController extends Controller
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

        // Key unik untuk cache berdasarkan parameter waktu
        $cacheKey = "tickets_{$date}_{$startTime}_{$endTime}";

        // Ambil dari cache jika tersedia, atau query dan simpan selama 10 menit
        $tickets = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($startDateTime, $endDateTime) {
            return Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
                ->whereBetween('created_at', [$startDateTime, $endDateTime])
                ->get();
        });

        // Ambil data regionals dengan cache
        $regionals = Cache::remember('monitoring_regionals', 60, function () {
            return Regional::select('id', 'regional_name')
                ->withCount('tickets')
                ->orderByDesc('tickets_count')
                ->get();
        });

        // Hitung data tiket
        $total_tiket = $tickets->count();
        $tiket_belum = $tickets->where('status.status_name', null)->count();
        $tiket_masuk = $tickets->count() - $tickets->whereIn('status.status_name', ['Selesai', 'Proses', 'Buka Kembali'])->count();
        $tiket_proses = $tickets->whereIn('status.status_name', ['Proses', 'Buka Kembali'])->count();
        $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
        $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();

        // Hitung jumlah tiket per regional
        $tickets_by_regional = $tickets->groupBy('regional_id')->map(function ($group) {
            return $group->count();
        });

        if ($request->ajax()) {
            return response()->json([
                'tickets' => $tickets,
                'total_tiket' => $total_tiket,
                'tiket_belum' => $tiket_belum,
                'tiket_masuk' => $tiket_masuk,
                'tiket_proses' => $tiket_proses,
                'tiket_tertunda' => $tiket_tertunda,
                'tiket_selesai' => $tiket_selesai,
                'tickets_by_regional' => $tickets_by_regional,
                'regionals' => $regionals,
            ]);
        }

        return view('dashboard.helpdesk.home.index', compact(
            'tickets',
            'tickets_by_regional',
            'regionals',
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
        $startTimeCarbon = Carbon::parse($selectedDate . ' ' . $startTime);
        $endTimeCarbon = Carbon::parse($selectedDate . ' ' . $endTime);

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

            // Buat cache key unik per shift dan parameter waktu
            $createdKey = "tickets_created_{$shift}_{$selectedDate}_{$startTime}_{$endTime}";
            $closedKey = "tickets_closed_{$shift}_{$selectedDate}_{$startTime}_{$endTime}";

            // Ambil dari cache jika ada, atau hitung dan simpan
            $createdCount = Cache::remember($createdKey, now()->addMinutes(10), function () use ($shiftStart, $shiftEnd, $startTimeCarbon, $endTimeCarbon) {
                return Ticket::whereBetween('created_at', [$shiftStart, $shiftEnd])
                    ->whereBetween('created_at', [$startTimeCarbon, $endTimeCarbon])
                    ->count();
            });

            $closedCount = Cache::remember($closedKey, now()->addMinutes(10), function () use ($shiftStart, $shiftEnd, $startTimeCarbon, $endTimeCarbon) {
                return Ticket::where('status_id', 4)
                    ->whereBetween('created_at', [$shiftStart, $shiftEnd])
                    ->whereBetween('created_at', [$startTimeCarbon, $endTimeCarbon])
                    ->count();
            });

            $ticketsCreated[] = $createdCount;
            $ticketsClosed[] = $closedCount;
        }

        return response()->json([
            'ticketsCreated' => $ticketsCreated,
            'ticketsClosed' => $ticketsClosed,
        ]);
    }


    public function indexAll(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');

        // Buat cache key unik berdasarkan parameter bulan dan tahun
        $cacheKey = "tickets_indexAll_" . ($month ?? 'null') . '_' . ($year ?? 'null');

        // Ambil data dari cache jika ada, jika tidak jalankan query dan simpan di cache
        $tickets = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($month, $year) {
            return Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
                ->when($year, function ($query) use ($year) {
                    if ($year !== "all") {
                        $query->whereYear('created_at', $year);
                    }
                })
                ->when($month, function ($query) use ($month) {
                    if ($month !== "all") {
                        $query->whereMonth('created_at', $month);
                    }
                })
                ->get();
        });

        // Hitung data tiket
        $total_tiket = $tickets->count();
        $tiket_belum = $tickets->where('status.status_name', null)->count();
        $tiket_masuk = $total_tiket - $tickets->whereIn('status.status_name', ['Selesai', 'Proses', 'Buka Kembali'])->count();
        $tiket_proses = $tickets->whereIn('status.status_name', ['Proses', 'Buka Kembali'])->count();
        $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
        $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();

        // Jika request Ajax
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

        // Return view
        return view('dashboard.helpdesk.home.indexAll', compact(
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
        $year = $request->input('year', null);
        $month = $request->input('month', null);

        // Buat cache key berdasarkan kombinasi year dan month
        $cacheKey = 'chart_data_' . ($year ?? 'all') . '_' . ($month ?? 'all');

        // Ambil data dari cache atau eksekusi query dan simpan ke cache selama 10 menit
        $chartData = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($year, $month) {
            $query = Ticket::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total');

            if ($year) {
                $query->whereYear('created_at', $year);
            }

            if ($month) {
                $query->whereMonth('created_at', $month);
            }

            $tickets = $query->groupBy('year', 'month')->get()->keyBy('month')->toArray();

            $queryClosed = Ticket::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
                ->where('status_id', 4);

            if ($year) {
                $queryClosed->whereYear('created_at', $year);
            }

            if ($month) {
                $queryClosed->whereMonth('created_at', $month);
            }

            $ticketsClosed = $queryClosed->groupBy('year', 'month')->get()->keyBy('month')->toArray();

            $chartData = [
                'months' => [],
                'tickets' => [],
                'ticketsClosed' => []
            ];

            $monthsRange = $month ? [$month] : range(1, 12);

            foreach ($monthsRange as $m) {
                $chartData['months'][] = Carbon::create()->month($m)->format('F');
                $chartData['tickets'][] = $tickets[$m]['total'] ?? 0;
                $chartData['ticketsClosed'][] = $ticketsClosed[$m]['total'] ?? 0;
            }

            return $chartData;
        });

        return response()->json($chartData);
    }


    public function getDailyTicketChartData(Request $request)
    {
        $year = $request->input('year', null);
        $month = $request->input('month', null);

        // Buat key cache unik berdasarkan tahun dan bulan
        $cacheKey = 'daily_chart_data_' . ($year ?? 'all') . '_' . ($month ?? 'all');

        // Ambil dari cache atau simpan jika belum ada
        $chartData = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($year, $month) {
            $startDate = $year ? Carbon::create($year, $month ?? 1, 1)->startOfMonth() : Ticket::min('created_at');
            $endDate = $year ? Carbon::create($year, $month ?? 12, 31)->endOfMonth() : Ticket::max('created_at');

            $ticketsCreated = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('day')
                ->get()
                ->keyBy('day')
                ->toArray();

            $ticketsClosed = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
                ->where('status_id', 4)
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

            $daysInMonth = Carbon::parse($endDate)->daysInMonth ?? 31;

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $chartData['days'][] = $i;
                $chartData['ticketsCreated'][] = $ticketsCreated[$i]['total'] ?? 0;
                $chartData['ticketsClosed'][] = $ticketsClosed[$i]['total'] ?? 0;
            }

            return $chartData;
        });

        return response()->json($chartData);
    }

    public function yearlySummary()
    {
        $cacheKey = 'yearly_summary';

        $yearlyData = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return Ticket::selectRaw("
                    YEAR(created_at) as year,
                    COUNT(*) as total_tickets,
                    SUM(CASE WHEN status_id = 4 THEN 1 ELSE 0 END) as closed_tickets
                ")
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->get();
        });

        return response()->json([
            'years' => $yearlyData->pluck('year'),
            'total_tickets' => $yearlyData->pluck('total_tickets'),
            'closed_tickets' => $yearlyData->pluck('closed_tickets')->map(fn($value) => $value ?? 0)
        ]);
    }



}
