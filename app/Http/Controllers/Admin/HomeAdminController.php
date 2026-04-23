<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Province;
use App\Models\CityOrRegency;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeAdminController extends Controller
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

        return view('dashboard.admin.home.index', compact(
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

        return view('dashboard.admin.home.indexAll', compact(
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
        $tickets = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        // Ambil data tiket selesai, hanya jika created_at juga dalam tahun yang diminta
        $ticketsClosed = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->whereYear('created_at', $year) // Tambahkan kondisi ini
            ->where('status_id', 4) // Asumsi 4 adalah ID untuk 'Tutup'
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

        return response()->json($chartData);
    }

    public function getDailyTicketChartData(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $startDate = Carbon::create($year, $month)->startOfMonth();
        $endDate = Carbon::create($year, $month)->endOfMonth();

        // Tickets Created Query
        $ticketsCreated = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('day')
            ->get()
            ->keyBy('day')
            ->toArray();

        // Tickets Closed Query (only if created_at is within the requested year)
        $ticketsClosed = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
            ->where('status_id', 4)
            ->whereYear('created_at', $year) // Ensure created_at is in the requested year
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('day')
            ->get()
            ->keyBy('day')
            ->toArray();

        // Prepare Chart Data
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

        return response()->json($chartData);
    }
    public function indexProblem(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');
        $provinceId = $request->query('province_id');
        $cityId = $request->query('city_id');
        $categoryId = $request->query('category_id');

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
            if ($year !== "all" && $year) {
                $query->whereYear('created_at', $year);
            }
        });

        // Filter bulan
        $query->when($month, function ($query) use ($month) {
            if ($month !== "all" && $month) {
                $query->whereMonth('created_at', $month);
            }
        });

        // Filter provinsi
        $query->when($provinceId, function ($query) use ($provinceId) {
            if ($provinceId !== "all" && $provinceId) {
                $query->where('province_id', $provinceId);
            }
        });

        // Filter kota
        $query->when($cityId, function ($query) use ($cityId) {
            if ($cityId !== "all" && $cityId) {
                $query->where('city_or_regency_id', $cityId);
            }
        });

        // Filter kategori
        $query->when($categoryId, function ($query) use ($categoryId) {
            if ($categoryId !== "all" && $categoryId) {
                $query->where('category_id', $categoryId);
            }
        });

        $topProblems = $query->limit(10)->get();

        // Define color palette
        $colorPalette = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#8AC24A', '#FF5722', '#607D8B', '#9C27B0'
        ];

        $chartData = $topProblems->map(function ($item, $index) use ($colorPalette) {
            $provinceName = $item->province->province_name ?? '-';
            $cityName = $item->cityOrRegency->city_or_regency_name ?? '-';
            $categoryCode = $item->category->code ?? $item->category->category_name ?? 'Unknown';
            
            return [
                'label' => $provinceName . ' - ' . $cityName . ' (' . $categoryCode . ')',
                'category_name' => $item->category->category_name ?? 'Unknown',
                'total' => $item->total,
                'color' => $colorPalette[$index % count($colorPalette)],
            ];
        });


        // Format data untuk tabel
        $tableData = $topProblems->map(function ($item) {
            return [
                'province' => $item->province->province_name ?? '-',
                'city' => $item->cityOrRegency->city_or_regency_name ?? '-',
                'category' => $item->category->category_name ?? 'Unknown',
                'code' => $item->category->code ?? '-',
                'color' => $item->category->color ?? '#6c757d',
                'total' => $item->total
            ];
        });

        // Data untuk dropdown filter
        $provinces = Province::orderBy('province_name')->get();
        $categories = Category::orderBy('category_name')->get();
        $years = Ticket::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($request->ajax()) {
            return response()->json([
                'chartData' => $chartData,
                'tableData' => $tableData,
                'provinces' => $provinces,
                'categories' => $categories,
                'years' => $years,
                'month' => $month,
                'year' => $year,
                'provinceId' => $provinceId,
                'cityId' => $cityId,
                'categoryId' => $categoryId
            ]);
        }

        return view('dashboard.admin.home.indexProblem', compact(
            'chartData',
            'tableData',
            'provinces',
            'categories',
            'years',
            'month',
            'year',
            'provinceId',
            'cityId',
            'categoryId'
        ));
    }
}
