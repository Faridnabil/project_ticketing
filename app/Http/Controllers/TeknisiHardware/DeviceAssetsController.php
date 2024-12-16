<?php

namespace App\Http\Controllers\TeknisiHardware;

use App\Http\Controllers\Controller;
use App\Models\DeviceAssets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeviceAssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deviceAssets = DeviceAssets::all();

        return view("dashboard.teknisi-perangkat.device-assets.index", compact("deviceAssets"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $deviceAssets = DeviceAssets::all();

        return view("dashboard.teknisi-perangkat.device-assets.create", compact("deviceAssets"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = $request->validate([
                'device_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'photo_location' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'photo_device' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Penanganan file upload untuk photo_location
            if ($request->hasFile('photo_location')) {
                $photoLocation = $request->file('photo_location');
                $photoLocationName = time() . "_" . $photoLocation->getClientOriginalName();
                $photoLocationFolder = 'device-assets/location';
                $filePath = $photoLocation->storeAs('public/' . $photoLocationFolder, $photoLocationName);
                $validate['photo_location'] = str_replace('public/', '', $filePath); // Path relatif
            }

            // Penanganan file upload untuk photo_device
            if ($request->hasFile('photo_device')) {
                $photoDevice = $request->file('photo_device');
                $photoDeviceName = time() . "_" . $photoDevice->getClientOriginalName();
                $photoDeviceFolder = 'device-assets/device';
                $filePath = $photoDevice->storeAs('public/' . $photoDeviceFolder, $photoDeviceName);
                $validate['photo_device'] = str_replace('public/', '', $filePath); // Path relatif
            }

            // Simpan data ke database
            DeviceAssets::create($validate);

            DB::commit();
            return redirect()->route('teknisiHardware.deviceAssets.index')->with('success', 'Aset Perangkat Berhasil Dibuat.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Aset Perangkat Gagal Dibuat');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(DeviceAssets $deviceAsset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceAssets $deviceAsset)
    {
        return view("dashboard.teknisi-perangkat.device-assets.edit", compact("deviceAsset"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeviceAssets $deviceAsset)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'device_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'photo_location' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'photo_device' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Update fields with the provided values
            $deviceAsset->device_name = $request->input('device_name');
            $deviceAsset->description = $request->input('description');

            // Handle file upload for photo_location
            if ($request->hasFile('photo_location')) {
                // Delete the old file if exists
                if ($deviceAsset->photo_location) {
                    Storage::delete('public/' . $deviceAsset->photo_location);
                }

                $photoLocation = $request->file('photo_location');
                $photoLocationName = time() . "_" . $photoLocation->getClientOriginalName();
                $photoLocationFolder = 'device-assets/location';
                $filePath = $photoLocation->storeAs('public/' . $photoLocationFolder, $photoLocationName);
                $deviceAsset->photo_location = str_replace('public/', '', $filePath); // Path relatif
            }

            // Handle file upload for photo_device
            if ($request->hasFile('photo_device')) {
                // Delete the old file if exists
                if ($deviceAsset->photo_device) {
                    Storage::delete('public/' . $deviceAsset->photo_device);
                }

                $photoDevice = $request->file('photo_device');
                $photoDeviceName = time() . "_" . $photoDevice->getClientOriginalName();
                $photoDeviceFolder = 'device-assets/device';
                $filePath = $photoDevice->storeAs('public/' . $photoDeviceFolder, $photoDeviceName);
                $deviceAsset->photo_device = str_replace('public/', '', $filePath); // Path relatif
            }

            $deviceAsset->save();

            DB::commit();
            return redirect()->route("teknisiHardware.deviceAssets.index")->with("success", "Aset Perangkat Berhasil Diperbarui.");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", 'Aset Perangkat Gagal Diperbarui.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceAssets $deviceAsset)
    {
        DB::beginTransaction();
        try {
            if (!$deviceAsset) {
                // Jika Aset Perangkat tidak ditemukan, kembalikan pesan kesalahan
                return back()->with(['error' => 'Aset Perangkat tidak ada.']);
            }

            // Hapus file terkait jika ada
            if ($deviceAsset->photo_location) {
                Storage::delete('public/' . $deviceAsset->photo_location);
            }

            if ($deviceAsset->photo_device) {
                Storage::delete('public/' . $deviceAsset->photo_device);
            }

            // Hapus Aset Perangkat dari database
            $deviceAsset->delete();

            DB::commit();
            return redirect()->route('teknisiHardware.deviceAssets.index')->with('success', 'Aset Perangkat berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Aset Perangkat gagal dihapus.');
        }
    }

}
