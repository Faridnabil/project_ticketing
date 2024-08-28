<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        // return $categories;
        // foreach ($categories as $key => $value) {
        //     $value -> service->service_name;
        // }
        // return $value;

        return view("dashboard.admin.category.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view("dashboard.admin.category.create", compact("services"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'category_name' => 'required|string|max:255',
            'layanan_id' => 'required|exists:services,id',
        ]);
        $c =  new Category;
        $c -> layanan_id = $request->layanan_id;
        $c -> category_name= $request->category_name;
        $c->save();
        return redirect()->route("category.index")->with("success", "Kategori Berhasil Dibuat!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view("dashboard.admin.category.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        DB::beginTransaction();
        try {
            $category->update($request->all());
            DB::commit();
            return redirect()->route("category.index")->with("success", "Kategori Berhasil Dirubah!");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try {
            $category->delete();
            DB::commit();
            return redirect()->route("category.index")->with("success","Kategori Berhasil Dihapus!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }
}
