<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = Status::all();

        return view("dashboard.status.index", compact("statuses"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.status.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $status = Status::create($request->all());

            DB::commit();
            return redirect()->route("status.index")->with("success", "Status Berhasil Dibuat.");
        } catch (\Throwable $th) {
              throw $th;
            DB::rollBack();
              dd($th->getMessage()); // Menampilkan pesan error untuk debugging
            return back()->with("error", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        return view("dashboard.status.edit", compact("status"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status)
    {
        DB::beginTransaction();
        try {
            $status->update($request->all());

            DB::commit();
            return redirect()->route("status.index")->with("success", "Status Berhasil Di Rubah.");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        DB::beginTransaction();
        try {
            $status->delete();

            DB::commit();
            return redirect()->route("status.index")->with("success", "Status Berhasil Dihapus.");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with("error", $th->getMessage());
        }
    }
}
