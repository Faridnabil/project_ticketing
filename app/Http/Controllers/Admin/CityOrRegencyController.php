<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CityOrRegency;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityOrRegencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $city_or_regencies = CityOrRegency::with('province')
            ->get();

        return view("dashboard.admin.city-or-regency.index", compact("city_or_regencies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();

        return view("dashboard.admin.city-or-regency.create", compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $city_or_regency = CityOrRegency::create($request->all());

            DB::commit();
            return redirect()->route("cityOrRegency.index")->with("success", "Kota/Kabupaten Berhasil Dibuat!");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CityOrRegency $cityOrRegency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CityOrRegency $cityOrRegency)
    {
        $provinces = Province::all();

        return view("dashboard.admin.city-or-regency.edit", compact('cityOrRegency', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CityOrRegency $cityOrRegency)
    {
        DB::beginTransaction();
        try {
            $cityOrRegency->update($request->all());
            DB::commit();
            return redirect()->route("cityOrRegency.index")->with("success", "Kota/Kabupaten Berhasil Dirubah!");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CityOrRegency $cityOrRegency)
    {
        DB::beginTransaction();
        try {
            $cityOrRegency->delete();
            DB::commit();
            return redirect()->route("cityOrRegency.index")->with("success", "Kota/Kabupaten Berhasil Dihapus!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }
}
