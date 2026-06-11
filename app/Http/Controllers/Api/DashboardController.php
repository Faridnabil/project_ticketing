<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CityOrRegency;
use App\Models\Province;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get summary of tickets (Total, Masuk, Proses, Selesai, etc)
     */
    public function getSummary(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');

        $tickets = Ticket::with('status')
            ->when($year, function ($query) use ($year) {
                if ($year !== "all" && $year) {
                    $query->whereYear('created_at', $year);
                }
            })
            ->when($month, function ($query) use ($month) {
                if ($month !== "all" && $month) {
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

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_tiket' => $total_tiket,
                'tiket_belum' => $tiket_belum,
                'tiket_masuk' => $tiket_masuk,
                'tiket_proses' => $tiket_proses,
                'tiket_tertunda' => $tiket_tertunda,
                'tiket_selesai' => $tiket_selesai,
            ]
        ]);
    }


    /**
     * Get the most tickets grouped by province
     */
    public function getTicketsByProvince(Request $request)
    {
        $query = Ticket::select(
                'province_id', 
                DB::raw('count(*) as total'),
                DB::raw('SUM(CASE WHEN status_id = 4 THEN 1 ELSE 0 END) as completed')
            )
            ->groupBy('province_id')
            ->orderByDesc('total');

        $data = $query->with('province')->get()->map(function ($ticket) {
            return [
                'no_prov' => $ticket->province->no_province ?? '-',
                'province_name' => $ticket->province->province_name ?? 'Unknown',
                'total' => $ticket->total,
                'completed' => (int) $ticket->completed,
                'not_completed' => $ticket->total - (int) $ticket->completed
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Get the most tickets grouped by city/regency
     */
    public function getTicketsByCity(Request $request)
    {
        $query = Ticket::select(
                'city_or_regency_id', 
                'province_id', 
                DB::raw('count(*) as total'),
                DB::raw('SUM(CASE WHEN status_id = 4 THEN 1 ELSE 0 END) as completed')
            )
            ->groupBy('city_or_regency_id', 'province_id')
            ->orderByDesc('total');

        $data = $query->with(['cityOrRegency', 'province'])->get()->map(function ($ticket) {
            return [
                'no_kab' => $ticket->cityOrRegency->no_city_or_regency ?? '-',
                'city_name' => $ticket->cityOrRegency->city_or_regency_name ?? 'Unknown',
                'no_prov' => $ticket->province->no_province ?? '-',
                'province_name' => $ticket->province->province_name ?? 'Unknown',
                'total' => $ticket->total,
                'completed' => (int) $ticket->completed,
                'not_completed' => $ticket->total - (int) $ticket->completed
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Get the count of incoming and completed tickets for today
     */
    public function getTodayTickets(Request $request)
    {
        $date = $request->query('date', Carbon::today()->toDateString());

        $incoming = Ticket::whereDate('created_at', $date)->count();

        $completed = Ticket::where('status_id', 4)
            ->whereDate('updated_at', $date)
            ->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'date' => $date,
                'incoming' => $incoming,
                'completed' => $completed
            ]
        ]);
    }
}
