<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\HistoryTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeKoordinatorController extends Controller
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
            ->where('level2', '!=', null)
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

        return view('dashboard.koordinator.home.index', compact(
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
                ->where('level2', '!=', null)
                ->whereBetween('created_at', [$startTime, $endTime])
                ->count();
            $ticketsClosed[] = Ticket::where('status_id', 4)
                ->where('level2', '!=', null)
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

        return view('dashboard.koordinator.home.indexAll', compact(
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
            ->groupByRaw("YEAR(created_at)")
            ->orderBy('year', 'desc')
            ->get();

        return response()->json([
            'years' => $yearlyData->pluck('year')->toArray(),
            'total_tickets' => $yearlyData->pluck('total_tickets')->toArray(),
            'closed_tickets' => $yearlyData->pluck('closed_tickets')->map(fn($v) => $v ?? 0)->toArray()
        ]);
    }

}
