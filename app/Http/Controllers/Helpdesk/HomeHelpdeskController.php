<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeHelpdeskController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year); // Default ke tahun berjalan
        $startTime = $request->query('startTime');
        $endTime = $request->query('endTime');

        // Parse startTime dan endTime jika ada
        if ($startTime) {
            $startTime = Carbon::createFromFormat('H:i', $startTime)->format('Y-m-d H:i:s');
        }
        if ($endTime) {
            $endTime = Carbon::createFromFormat('H:i', $endTime)->format('Y-m-d H:i:s');
        }

        // Construct the query
        $tickets = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
            ->when($month && $year, function ($query) use ($month, $year) {
                $query->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month);
            })
            ->when($startTime && $endTime, function ($query) use ($startTime, $endTime) {
                $query->whereBetween('created_at', [$startTime, $endTime]);
            })
            ->get();

        // Calculate the ticket counts
        if ($startTime && $endTime) {

            // Calculate the ticket counts
            $total_tiket = $tickets->count();
            $tiket_belum = $tickets->where('status.status_name', null)->count();
            $tiket_masuk = $tickets->count() - $tickets->whereIn('status.status_name', ['Selesai', 'Proses', 'Buka Kembali'])->count();
            $tiket_proses = $tickets->whereIn('status.status_name', ['Proses', 'Buka Kembali'])->count();
            $tiket_tertunda = $tickets->where('status.status_name', 'Tertunda')->count();
            $tiket_selesai = $tickets->where('status.status_name', 'Selesai')->count();
        } else {
            // If no filters are applied, set the ticket counts to null or an empty string
            $tickets = collect();  // Empty collection
            $total_tiket = 0;
            $tiket_belum = 0;
            $tiket_masuk = 0;
            $tiket_proses = 0;
            $tiket_tertunda = 0;
            $tiket_selesai = 0;
        }

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
            'endTime'
        ));
    }


    public function indexAll(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year); // Default ke tahun berjalan

        $tickets = Ticket::with('status', 'category', 'priority', 'helpdesk', 'koordinator', 'staffSubdit', 'siakDev', 'pejabat')
            ->when($month && $year, function ($query) use ($month, $year) {
                $query->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month);
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
        $ticketsClosed = Ticket::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
            ->whereYear('updated_at', $year)
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
        $ticketsClosed = Ticket::selectRaw('DAY(updated_at) as day, COUNT(*) as total')
            ->where('status_id', 4)
            ->whereYear('created_at', $year) // Ensure created_at is in the requested year
            ->whereBetween('updated_at', [$startDate, $endDate])
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

    public function todaygetTicketChartData(Request $request)
    {
        $startTime = $request->input('startTime', '00:00');
        $endTime = $request->input('endTime', '23:59');
        $date = $request->input('date', today()->toDateString()); // Ensure there's a date passed

        // Ensure that we are parsing times and dates correctly
        $startTime = Carbon::parse($startTime);
        $endTime = Carbon::parse($endTime);

        // Tentukan rentang waktu setiap shift
        $shifts = [
            'shift1' => ['07:00:00', '15:00:00'],
            'shift2' => ['15:00:00', '23:00:00'],
            'shift3' => ['23:00:00', '07:00:00'],
        ];

        $ticketsCreated = [];
        $ticketsClosed = [];

        foreach ($shifts as $shift => [$startShift, $endShift]) {
            if ($shift === 'shift3') {
                // Shift malam (melewati tengah malam)
                $startDateTime = Carbon::parse($date . ' ' . $startShift);
                $endDateTime = Carbon::parse($date . ' ' . $endShift)->addDay();
            } else {
                $startDateTime = Carbon::parse($date . ' ' . $startShift);
                $endDateTime = Carbon::parse($date . ' ' . $endShift);
            }

            // Filter tickets based on startTime and endTime
            $ticketsCreated[] = Ticket::whereBetween('created_at', [$startDateTime, $endDateTime])
                ->whereBetween('created_at', [$startTime, $endTime]) // Apply additional filter for created_at
                ->count();
            $ticketsClosed[] = Ticket::where('status_id', 4)
                ->whereBetween('updated_at', [$startDateTime, $endDateTime])
                ->whereBetween('updated_at', [$startTime, $endTime]) // Apply additional filter for updated_at
                ->count();
        }

        return response()->json([
            'ticketsCreated' => $ticketsCreated,
            'ticketsClosed' => $ticketsClosed,
        ]);
    }
}
