<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priorities = Priority::all();

        return view("dashboard.priority.index", compact("priorities"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.priority.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $priority = Priority::create($request->all());

            DB::commit();
            return redirect()->route("priority.index")->with("success", "Prioritas Berhasil Ditambahkan.");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Priority $priority)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Priority $priority)
    {
        return view("dashboard.priority.edit", compact("priority"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Priority $priority)
    {
        DB::beginTransaction();
        try {
            $priority->update($request->all());

            DB::commit();
            return redirect()->route("priority.index")->with("success", "Prioritas Berhasil Di Perbarui.");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Priority $priority)
    {
        DB::beginTransaction();
        try {
            $priority->delete();

            DB::commit();
            return redirect()->route("dashboard.priority.index")->with("success", "Prioritas Berhasil Di Hapus.");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }
}
