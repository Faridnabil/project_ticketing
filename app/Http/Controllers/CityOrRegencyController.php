<?php

namespace App\Http\Controllers;

use App\Exports\CityOrRegencyExport;
use App\Http\Controllers\Controller;
use App\Imports\CityOrRegencyImport;
use App\Models\CityOrRegency;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CityOrRegencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $city_or_regencies = CityOrRegency::with('province')
            ->get();

        return view("dashboard.city-or-regency.index", compact("city_or_regencies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();

        return view("dashboard.city-or-regency.create", compact('provinces'));
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

        return view("dashboard.city-or-regency.edit", compact('cityOrRegency', 'provinces'));
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

    public function exportFormat()
    {
        return Excel::download(new CityOrRegencyExport, 'cityOrRegency-format.xlsx');
    }

    public function export()
    {
        return Excel::download(new CityOrRegencyExport, 'cityOrRegency.xlsx');
    }

    public function import()
    {
        try {
            Excel::import(new CityOrRegencyImport, request()->file('your_file'));

            return redirect()->route("cityOrRegency.index")->with('success', 'Kota/Kabupaten Berhasil Di Import!');
        } catch (\Throwable $th) {
            return back()->with("error", $th->getMessage());
        }
    }
}
