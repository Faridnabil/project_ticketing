<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\CityOrRegency;
use App\Models\Province;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Query tiket berdasarkan tanggal dan waktu yang dipilih
        $tickets = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->get();

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

        return view('dashboard.helpdesk.home.index', compact(
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
                ->whereBetween('created_at', [$startTime, $endTime])
                ->count();
            $ticketsClosed[] = Ticket::where('status_id', 4)
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
        $month = $request->query('month');
        $year = $request->query('year');

        $tickets = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
            ->when($year, function ($query) use ($year) {
                if ($year !== "all") { // Jangan filter jika "Semua Tahun" dipilih
                    $query->whereYear('created_at', $year);
                }
            })
            ->when($month, function ($query) use ($month) {
                if ($month !== "all") { // Jangan filter jika "Semua Bulan" dipilih
                    $query->whereMonth('created_at', $month);
                }
            })
            ->get();

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

    public function indexProblem(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');
        $provinceId = $request->query('province_id');
        $cityId = $request->query('city_id');

        $query = Ticket::with(['province', 'cityOrRegency', 'category'])
            ->select(
                'province_id',
                'city_or_regency_id',
                'category_id',
                DB::raw('count(*) as total')
            )
            ->groupBy('province_id', 'city_or_regency_id', 'category_id')
            ->orderByDesc('total');

        // Filter tahun
        $query->when($year, function ($query) use ($year) {
            if ($year !== "all") {
                $query->whereYear('created_at', $year);
            }
        });

        // Filter bulan
        $query->when($month, function ($query) use ($month) {
            if ($month !== "all") {
                $query->whereMonth('created_at', $month);
            }
        });

        // Filter provinsi
        $query->when($provinceId, function ($query) use ($provinceId) {
            if ($provinceId !== "all") {
                $query->where('province_id', $provinceId);
            }
        });

        // Filter kota
        $query->when($cityId, function ($query) use ($cityId) {
            if ($cityId !== "all") {
                $query->where('city_or_regency_id', $cityId);
            }
        });

        $topProblems = $query->limit(10)->get();

        // Format data untuk chart Random Soft
        // function generatePastelColor()
        // {
        //     $r = mt_rand(100, 255);
        //     $g = mt_rand(100, 255);
        //     $b = mt_rand(100, 255);
        //     return sprintf("#%02X%02X%02X", $r, $g, $b);
        // }

        // $chartData = $topProblems->map(function ($item) {
        //     return [
        //         'region' => $item->province->province_name .
        //             ($item->cityOrRegency ? ' - ' . $item->cityOrRegency->city_or_regency_name : ''),
        //         'total' => $item->total,
        //         'category' => $item->category->category_name ?? 'Unknown',
        //         'color' => generatePastelColor(),
        //     ];
        // });

        // Define color palette
        $colorPalette = [
            '#FF6384',
            '#36A2EB',
            '#FFCE56',
            '#4BC0C0',
            '#9966FF',
            '#FF9F40',
            '#8AC24A',
            '#FF5722',
            '#607D8B',
            '#9C27B0',
            '#E91E63',
            '#00BCD4',
            '#CDDC39',
            '#795548',
            '#3F51B5'
        ];

        $chartData = $topProblems->map(function ($item, $index) use ($colorPalette) {
            return [
                'region' => $item->province->province_name .
                    ($item->cityOrRegency ? ' - ' . $item->cityOrRegency->city_or_regency_name : ''),
                'total' => $item->total,
                'category' => $item->category->category_name ?? 'Unknown',
                'description' => $item->category->description ?? 'Unknown',
                'color' => $colorPalette[$index % count($colorPalette)], // Warna dari palette
            ];
        });


        // Format data untuk tabel
        $tableData = $topProblems->map(function ($item) {
            return [
                'province' => $item->province->province_name,
                'city' => $item->cityOrRegency->city_or_regency_name ?? '-',
                'category' => $item->category->category_name ?? 'Unknown',
                'description' => $item->category->description ?? 'Unknown',
                'total' => $item->total
            ];
        });

        // Data untuk dropdown filter
        $provinces = Province::orderBy('province_name')->get();
        $years = Ticket::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($request->ajax()) {
            return response()->json([
                'chartData' => $chartData,
                'tableData' => $tableData,
                'provinces' => $provinces,
                'years' => $years,
                'month' => $month,
                'year' => $year,
                'provinceId' => $provinceId,
                'cityId' => $cityId
            ]);
        }

        return view('dashboard.helpdesk.home.indexProblem', compact(
            'chartData',
            'tableData',
            'provinces',
            'years',
            'month',
            'year',
            'provinceId',
            'cityId'
        ));
    }

    public function getCities($provinceId)
    {
        $cities = CityOrRegency::where('province_id', $provinceId)
            ->orderBy('city_or_regency_name')
            ->get();

        return response()->json($cities);
    }

    public function getTicketChartData(Request $request)
    {
        $year = $request->input('year', null); // Bisa null jika ingin semua tahun
        $month = $request->input('month', null); // Bisa null jika ingin semua bulan

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

        return response()->json($chartData);
    }


    public function getDailyTicketChartData(Request $request)
    {
        $year = $request->input('year', null);
        $month = $request->input('month', null);

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

        $daysInMonth = $endDate ? Carbon::parse($endDate)->day : 31;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $chartData['days'][] = $i;
            $chartData['ticketsCreated'][] = $ticketsCreated[$i]['total'] ?? 0;
            $chartData['ticketsClosed'][] = $ticketsClosed[$i]['total'] ?? 0;
        }

        return response()->json($chartData);
    }

    public function yearlySummary()
    {
        $yearlyData = Ticket::selectRaw("
                YEAR(created_at) as year,
                COUNT(*) as total_tickets,
                SUM(CASE WHEN status_id = 4 THEN 1 ELSE 0 END) as closed_tickets
            ")
            ->groupBy('year')
            ->orderBy('year', 'desc') // Menampilkan tahun terbaru lebih dulu
            ->get();

        return response()->json([
            'years' => $yearlyData->pluck('year'),
            'total_tickets' => $yearlyData->pluck('total_tickets'),
            'closed_tickets' => $yearlyData->pluck('closed_tickets')->map(fn($value) => $value ?? 0)
        ]);
    }



}
