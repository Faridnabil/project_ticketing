<?php

namespace App\Http\Controllers;

use App\Exports\ProvinceExport;
use App\Exports\ProvinceFormatExport;
use App\Http\Controllers\Controller;
use App\Imports\ProvinceImport;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinces = Province::all();

        return view("dashboard.province.index", compact("provinces"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.province.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $province = Province::create($request->all());

            DB::commit();
            return redirect()->route("province.index")->with("success", "Provinsi Berhasil Dibuat!");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        return view("dashboard.province.edit", compact('province'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        DB::beginTransaction();
        try {
            $province->update($request->all());
            DB::commit();
            return redirect()->route("province.index")->with("success", "Provinsi Berhasil Dirubah!");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        DB::beginTransaction();
        try {
            $province->delete();
            DB::commit();
            return redirect()->route("province.index")->with("success", "Provinsi Berhasil Dihapus!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }

    public function exportFormat()
    {
        return Excel::download(new ProvinceFormatExport, 'province-format.xlsx');
    }

    public function export()
    {
        return Excel::download(new ProvinceExport, 'province.xlsx');
    }

    public function import()
    {
        try {
            Excel::import(new ProvinceImport, request()->file('your_file'));

            return redirect()->route("province.index")->with('success', 'Provinsi Berhasil Di Import!');
        } catch (\Throwable $th) {
            return back()->with("error", $th->getMessage());
        }
    }
}
