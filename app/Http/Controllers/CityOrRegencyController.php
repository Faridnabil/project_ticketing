<?php

namespace App\Http\Controllers;

use App\Exports\CityOrRegencyExport;
use App\Exports\CityOrRegencyFormatExport;
use App\Http\Controllers\Controller;
use App\Imports\CityOrRegencyImport;
use App\Models\CityOrRegency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @OA\Tag(
 * name="CityOrRegency",
 * description="Operations related to city or regencies"
 * )
 * @OA\Schema(
 *     schema="CityOrRegency",
 *     type="object",
 *     required={"province_id", "no_city_or_regency", "city_or_regency_name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="province_id", type="integer", example=1),
 *     @OA\Property(property="no_city_or_regency", type="string", example="123"),
 *     @OA\Property(property="city_or_regency_name", type="string", example="Jakarta"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-17T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-17T12:00:00Z")
 * )
 */
class CityOrRegencyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/city-or-regency",
     *     summary="Get all cities or regencies",
     *     tags={"CityOrRegency"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of cities or regencies")
     * )
     */
    public function index()
    {
        return response()->json(CityOrRegency::with('province')->get(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/city-or-regency",
     *     summary="Create a new city or regency",
     *     tags={"CityOrRegency"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"province_id", "no_city_or_regency", "city_or_regency_name"},
     *             @OA\Property(property="province_id", type="integer"),
     *             @OA\Property(property="no_city_or_regency", type="string"),
     *             @OA\Property(property="city_or_regency_name", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="City or regency created")
     * )
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $cityOrRegency = CityOrRegency::create($request->all());
            DB::commit();
            return response()->json($cityOrRegency, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/city-or-regency/{id}",
     *     summary="Get a specific city or regency",
     *     tags={"CityOrRegency"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="City or regency found")
     * )
     */
    public function show($id)
    {
        $cityOrRegency = CityOrRegency::find($id);
        if (!$cityOrRegency) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($cityOrRegency, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/city-or-regency/{id}",
     *     summary="Update a city or regency",
     *     tags={"CityOrRegency"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CityOrRegency")
     *     ),
     *     @OA\Response(response=200, description="City or regency updated")
     * )
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $cityOrRegency = CityOrRegency::findOrFail($id);
            $cityOrRegency->update($request->all());
            DB::commit();
            return response()->json($cityOrRegency, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/city-or-regency/{id}",
     *     summary="Delete a city or regency",
     *     tags={"CityOrRegency"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="City or regency deleted")
     * )
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $cityOrRegency = CityOrRegency::findOrFail($id);
            $cityOrRegency->delete();
            DB::commit();
            return response()->json(['message' => 'Deleted successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/city-or-regency/export-format",
     *     summary="Export format city or regency data",
     *     tags={"CityOrRegency"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Excel format file exported")
     * )
     */
    public function exportFormat()
    {
        return Excel::download(new CityOrRegencyFormatExport, 'cityOrRegency-format.xlsx');
    }

    /**
     * @OA\Get(
     *     path="/api/city-or-regency/export",
     *     summary="Export city or regency data",
     *     tags={"CityOrRegency"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Excel file exported")
     * )
     */
    public function export()
    {
        return Excel::download(new CityOrRegencyExport, 'cityOrRegency.xlsx');
    }

    /**
     * @OA\Post(
     *     path="/api/city-or-regency/import",
     *     summary="Import city or regency data",
     *     tags={"CityOrRegency"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(mediaType="multipart/form-data", @OA\Schema(@OA\Property(property="file", type="string", format="binary")))
     *     ),
     *     @OA\Response(response=200, description="Data imported successfully")
     * )
     */
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xlsx']);
        Excel::import(new CityOrRegencyImport, $request->file('file'));
        return response()->json(["message" => "Import successful"], 200);
    }
}
