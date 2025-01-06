<?php

namespace App\Http\Controllers\StaffSubdit;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeStaffSubditController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year); // Default ke tahun berjalan
        // Mengambil semua tiket
        $tickets = Ticket::with('status', 'category', 'priority', 'staffSubdit')
            ->where('level3', '!=', null)
            ->when($month && $year, function ($query) use ($month, $year) {
                $query->whereYear('created_at', $year)
                      ->whereMonth('created_at', $month);
            })
            ->get();

        // Menghitung jumlah tiket berdasarkan status
        $total_tiket = $tickets
            ->count();
        $tiket_belum = $tickets
            ->where('status.status_name', null)
            ->count();
        $tiket_masuk = $tickets->count() - $tickets->whereIn('status.status_name', ['Selesai', 'Proses', 'Buka Kembali'])->count();
        $tiket_proses = $tickets
            ->whereIn('status.status_name', ['Proses', 'Buka Kembali'])
            ->count();
        $tiket_tertunda = $tickets
            ->where('status.status_name', 'Tertunda')
            ->count();
        $tiket_selesai = $tickets
            ->where('status.status_name', 'Selesai')
            ->count();

        return view(
            'dashboard.staff-subdit.home.index',
            compact(
                'tickets',
                'total_tiket',
                'tiket_belum',
                'tiket_masuk',
                'tiket_proses',
                'tiket_tertunda',
                'tiket_selesai',
                'month',
                'year',
            )
        );
    }

    public function getTicketChartData(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        // Ambil data tiket masuk
        $tickets = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->where('level3', '!=', null)
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        // Ambil data tiket selesai
        $ticketsClosed = Ticket::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
            ->whereYear('updated_at', $year)
            ->where('level3', '!=', null)
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

        $ticketsCreated = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
            ->where('level3', '!=', null)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('day')
            ->get()
            ->keyBy('day')
            ->toArray();

        $ticketsClosed = Ticket::selectRaw('DAY(updated_at) as day, COUNT(*) as total')
            ->where('level3', '!=', null)
            ->where('status_id', 4)
            ->whereBetween('updated_at', [$startDate, $endDate])
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

        // Debugging output
        return response()->json($chartData);
    }
}
