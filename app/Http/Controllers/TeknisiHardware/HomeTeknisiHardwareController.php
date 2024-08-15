<?php

namespace App\Http\Controllers\TeknisiHardware;

use App\Http\Controllers\Controller;
use App\Models\DeviceAssets;
use Illuminate\Http\Request;

class HomeTeknisiHardwareController extends Controller
{
    public function index(Request $request)
    {
        $deviceAsset = DeviceAssets::all();

        $total = $deviceAsset->count();

        return view('dashboard.teknisi-perangkat.home.index', compact('deviceAsset', 'total'));
    }
}
