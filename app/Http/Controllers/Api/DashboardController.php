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
     * Get Monthly Ticket Chart
     */
    public function getMonthlyChart(Request $request)
    {
        $year = $request->input('year', null);
        $month = $request->input('month', null);

        if ($year === 'all') $year = null;
        if ($month === 'all') $month = null;

        // Jika tahun tidak dipilih (Semua Tahun), tampilkan data per TAHUN
        if (!$year) {
            $yearlyData = Ticket::selectRaw("
                    YEAR(created_at) as year,
                    COUNT(*) as total_tickets,
                    SUM(CASE WHEN status_id = 4 THEN 1 ELSE 0 END) as closed_tickets
                ")
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'type' => 'yearly',
                'data' => [
                    'labels' => $yearlyData->pluck('year'),
                    'tickets' => $yearlyData->pluck('total_tickets'),
                    'ticketsClosed' => $yearlyData->pluck('closed_tickets')->map(fn($value) => (int) $value)
                ]
            ]);
        }

        // Jika tahun dipilih, tampilkan data per BULAN untuk tahun tersebut
        $query = Ticket::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total');
        $query->whereYear('created_at', $year);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        $tickets = $query->groupBy('year', 'month')->get()->keyBy('month')->toArray();

        $queryClosed = Ticket::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('status_id', 4) // 4 = Selesai
            ->whereYear('created_at', $year);

        if ($month) {
            $queryClosed->whereMonth('created_at', $month);
        }

        $ticketsClosed = $queryClosed->groupBy('year', 'month')->get()->keyBy('month')->toArray();

        $chartData = [
            'labels' => [],
            'tickets' => [],
            'ticketsClosed' => []
        ];

        $monthsRange = $month ? [$month] : range(1, 12);

        foreach ($monthsRange as $m) {
            $chartData['labels'][] = Carbon::create()->month($m)->format('F');
            $chartData['tickets'][] = $tickets[$m]['total'] ?? 0;
            $chartData['ticketsClosed'][] = $ticketsClosed[$m]['total'] ?? 0;
        }

        return response()->json([
            'status' => 'success',
            'type' => 'monthly',
            'data' => $chartData
        ]);
    }

    /**
     * Get Daily Ticket Chart (Perbulan)
     */
    public function getDailyChart(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        if ($year === 'all') $year = Carbon::now()->year;
        if ($month === 'all') $month = Carbon::now()->month;

        $startDate = Carbon::create($year, $month)->startOfMonth();
        $endDate = Carbon::create($year, $month)->endOfMonth();

        // Tickets Created Query
        $ticketsCreated = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('day')
            ->get()
            ->keyBy('day')
            ->toArray();

        // Tickets Closed Query
        $ticketsClosed = Ticket::selectRaw('DAY(created_at) as day, COUNT(*) as total')
            ->where('status_id', 4) // 4 = Selesai
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

        return response()->json([
            'status' => 'success',
            'type' => 'daily',
            'data' => $chartData
        ]);
    }

    /**
     * Get Problem Report (Chart & Table)
     */
    public function getProblemReport(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');
        $provinceId = $request->query('province_id');
        $cityId = $request->query('city_id');
        $categoryId = $request->query('category_id');

        // Convert no_province to province_id by looking up in Province table
        $actualProvinceId = null;
        if ($provinceId && $provinceId !== "all") {
            $province = Province::where('no_province', $provinceId)->first();
            $actualProvinceId = $province ? $province->id : null;
        }

        $applyFilters = function ($query) use ($year, $month, $actualProvinceId, $cityId, $categoryId) {
            $query->when($year, function ($q) use ($year) {
                if ($year !== "all" && $year) {
                    $q->whereYear('created_at', $year);
                }
            })
            ->when($month, function ($q) use ($month) {
                if ($month !== "all" && $month) {
                    $q->whereMonth('created_at', $month);
                }
            })
            ->when($actualProvinceId, function ($q) use ($actualProvinceId) {
                if ($actualProvinceId) {
                    $q->where('province_id', $actualProvinceId);
                }
            })
            ->when($cityId, function ($q) use ($cityId) {
                if ($cityId !== "all" && $cityId) {
                    $q->where('city_or_regency_id', $cityId);
                }
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                if ($categoryId !== "all" && $categoryId) {
                    $q->where('category_id', $categoryId);
                }
            });
        };

        $isProvinceSelected = ($actualProvinceId && $actualProvinceId !== null);

        if ($isProvinceSelected) {
            $chartQuery = Ticket::with(['province', 'cityOrRegency'])
                ->select('province_id', 'city_or_regency_id', DB::raw('count(*) as total'))
                ->groupBy('province_id', 'city_or_regency_id')
                ->orderByDesc('total');
        } else {
            $chartQuery = Ticket::with(['province'])
                ->select('province_id', DB::raw('count(*) as total'))
                ->groupBy('province_id')
                ->orderByDesc('total');
        }

        $applyFilters($chartQuery);
        $topRegions = $chartQuery->limit(10)->get();

        if ($isProvinceSelected) {
            $tableQuery = Ticket::with(['province', 'cityOrRegency', 'category'])
                ->select('province_id', 'city_or_regency_id', 'category_id', DB::raw('count(*) as total'))
                ->groupBy('province_id', 'city_or_regency_id', 'category_id');
        } else {
            $tableQuery = Ticket::with(['province', 'category'])
                ->select('province_id', 'category_id', DB::raw('count(*) as total'))
                ->groupBy('province_id', 'category_id');
        }

        $applyFilters($tableQuery);

        $topProvinceIds = $topRegions->pluck('province_id')->unique();
        if ($isProvinceSelected) {
            $topCityIds = $topRegions->pluck('city_or_regency_id')->unique();
            if ($topProvinceIds->isNotEmpty() && $topCityIds->isNotEmpty()) {
                $tableQuery->whereIn('province_id', $topProvinceIds)->whereIn('city_or_regency_id', $topCityIds);
            }
        } else {
            if ($topProvinceIds->isNotEmpty()) {
                $tableQuery->whereIn('province_id', $topProvinceIds);
            }
        }
        $allProblems = $tableQuery->get();

        $colorPalette = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#8AC24A', '#FF5722', '#607D8B', '#9C27B0'
        ];

        $chartData = $topRegions->map(function ($item, $index) use ($colorPalette, $isProvinceSelected) {
            $provinceName = $item->province->province_name ?? '-';
            $noProvince = $item->province->no_province ?? '-';

            if ($isProvinceSelected) {
                $cityName = $item->cityOrRegency->city_or_regency_name ?? '-';
                $noCityOrRegency = $item->cityOrRegency->no_city_or_regency ?? '-';
                $label = $provinceName . ' - ' . $cityName;
            } else {
                $label = $provinceName;
                $noCityOrRegency = null;
            }

            return [
                'label' => $label,
                'kode_provinsi' => $noProvince,
                'kode_kota' => $noCityOrRegency,
                'total' => $item->total,
                'color' => $colorPalette[$index % count($colorPalette)],
            ];
        });

        $tableData = $topRegions->map(function ($region) use ($allProblems, $isProvinceSelected) {
            if ($isProvinceSelected) {
                $regionProblems = $allProblems->where('province_id', $region->province_id)
                                              ->where('city_or_regency_id', $region->city_or_regency_id)
                                              ->sortByDesc('total');
                $city = $region->cityOrRegency->city_or_regency_name ?? '-';
            } else {
                $regionProblems = $allProblems->where('province_id', $region->province_id)
                                              ->sortByDesc('total');
                $city = 'Semua Kota/Kabupaten';
            }

            $categoriesList = $regionProblems->map(function ($item) {
                return [
                    'category_name' => $item->category->code ?? $item->category->category_name ?? 'Unknown',
                    'color' => $item->category->color ?? '#6c757d',
                    'total' => $item->total
                ];
            })->values();

            return [
                'province' => $region->province->province_name ?? '-',
                'city' => $city,
                'total' => $region->total,
                'categories' => $categoriesList
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'chartData' => $chartData,
                'tableData' => $tableData,
            ]
        ]);
    }
}
