<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\Regional;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use Illuminate\Support\Facades\Cache;

class MonitoringTicketController extends Controller
{
    public function index()
    {
        // Cache untuk data regional
        $regionals = Cache::remember('monitoring_regionals', 60, function () {
            return Regional::select('id', 'regional_name')
                ->withCount('tickets')
                ->orderByDesc('tickets_count')
                ->get();
        });

        // Cache untuk data provinsi
        $provinsis = Cache::remember('monitoring_provinsis', 60, function () {
            return Provinsi::select('id', 'name', 'regional_id')
                ->withCount('tickets')
                ->orderByDesc('tickets_count')
                ->get();
        });

        // Cache untuk data kabupaten
        $kabupatens = Cache::remember('monitoring_kabupatens', 60, function () {
            return Kabupaten::select('id', 'name', 'type', 'provinsi_id')
                ->withCount('tickets')
                ->orderByDesc('tickets_count')
                ->get();
        });

        return view('dashboard.helpdesk.ticket.monitoring', compact('regionals', 'provinsis', 'kabupatens'));
    }
}
