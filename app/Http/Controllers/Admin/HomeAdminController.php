<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

        // Gunakan cache dengan key unik berdasarkan tanggal dan waktu
        $cacheKey = "tickets_{$date}_{$startTime}_{$endTime}";

        $tickets = Cache::remember($cacheKey, 600, function () use ($startDateTime, $endDateTime) {
            return Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
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

        // Key unik untuk cache berdasarkan parameter request
        $cacheKey = "ticket_chart_{$selectedDate}_{$startTime->format('H:i')}_{$endTime->format('H:i')}";

        $data = Cache::remember($cacheKey, 600, function () use ($shifts, $selectedDate, $startTime, $endTime) {
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

            return [
                'ticketsCreated' => $ticketsCreated,
                'ticketsClosed' => $ticketsClosed,
            ];
        });

        return response()->json($data);
    }


    public function indexAll(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        // Key unik untuk cache berdasarkan bulan dan tahun
        $cacheKey = "tickets_{$year}_{$month}";

        // Mengambil data dari cache atau query jika belum ada
        $data = Cache::remember($cacheKey, 600, function () use ($month, $year) {
            $tickets = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
                ->when($month && $year, function ($query) use ($month, $year) {
                    $query->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month);
                })
                ->get();

            return [
                'tickets' => $tickets,
                'total_tiket' => $tickets->count(),
                'tiket_belum' => $tickets->where('status.status_name', null)->count(),
                'tiket_masuk' => $tickets->count() - $tickets->whereIn('status.status_name', ['Selesai', 'Proses', 'Buka Kembali'])->count(),
                'tiket_proses' => $tickets->whereIn('status.status_name', ['Proses', 'Buka Kembali'])->count(),
                'tiket_tertunda' => $tickets->where('status.status_name', 'Tertunda')->count(),
                'tiket_selesai' => $tickets->where('status.status_name', 'Selesai')->count(),
            ];
        });

        if ($request->ajax()) {
            return response()->json($data);
        }

        return view('dashboard.admin.home.indexAll', array_merge($data, compact('month', 'year')));
    }

    public function getTicketChartData(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        // Key unik untuk cache berdasarkan tahun
        $cacheKey = "ticket_chart_data_{$year}";

        // Mengambil data dari cache atau query jika belum ada
        $chartData = Cache::remember($cacheKey, 3600, function () use ($year) {
            // Ambil data tiket masuk
            $tickets = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->get()
                ->keyBy('month')
                ->toArray();

            // Ambil data tiket selesai dengan status_id = 4
            $ticketsClosed = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->where('status_id', 4) // Asumsi 4 adalah ID untuk 'Tutup'
                ->groupBy('month')
                ->get()
                ->keyBy('month')
                ->toArray();

            // Inisialisasi data grafik
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

        return response()->json($chartData);
    }

    public function getDailyTicketChartData(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $startDate = Carbon::create($year, $month)->startOfMonth();
        $endDate = Carbon::create($year, $month)->endOfMonth();

        // Gunakan cache dengan key berdasarkan tahun dan bulan
        $cacheKey = "daily_ticket_chart_{$year}_{$month}";

        $chartData = Cache::remember($cacheKey, 3600, function () use ($startDate, $endDate, $year) {
            // Tickets Created Query
            $ticketsCreated = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('day')
                ->get()
                ->keyBy('day')
                ->toArray();

            // Tickets Closed Query
            $ticketsClosed = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
                ->where('status_id', 4)
                ->whereYear('created_at', $year)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('day')
                ->get()
                ->keyBy('day')
                ->toArray();

            // Siapkan data grafik
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

        return response()->json($chartData);
    }
}
