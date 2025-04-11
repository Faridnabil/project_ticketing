<?php

namespace App\Http\Controllers\TeknisiHardware;

use App\Http\Controllers\Controller;
use App\Models\DeviceAssets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeTeknisiHardwareController extends Controller
{
    public function index(Request $request)
    {
        // Cache data device asset selama 5 menit
        $deviceAsset = Cache::remember('device_assets_all', now()->addMinutes(5), function () {
            return DeviceAssets::all();
        });

        // Hitung total dari cache hasil
        $total = $deviceAsset->count();

        return view('dashboard.teknisi-perangkat.home.index', compact('deviceAsset', 'total'));
    }
}
