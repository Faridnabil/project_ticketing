<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncidentalActivityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncidentalActivityCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = IncidentalActivityCategory::all();

        return view("dashboard.admin.incidental-activity-category.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.admin.incidental-activity-category.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $category = IncidentalActivityCategory::create($request->all());

            DB::commit();
            return redirect()->route("incidental-activity-category.index")->with("success", "Kategori Berhasil Dibuat!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncidentalActivityCategory $incidentalActivityCategory)
    {
        return view("dashboard.admin.incidental-activity-category.edit", compact("incidentalActivityCategory"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncidentalActivityCategory $incidentalActivityCategory)
    {
        DB::beginTransaction();
        try {
            $incidentalActivityCategory->update($request->all());
            DB::commit();
            return redirect()->route("incidental-activity-category.index")->with("success", "Kategori Berhasil Dirubah!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncidentalActivityCategory $incidentalActivityCategory)
    {
        DB::beginTransaction();
        try {
            $incidentalActivityCategory->delete();
            DB::commit();
            return redirect()->route("incidental-activity-category.index")->with("success", "Kategori Berhasil Dihapus!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }
}
