<?php

namespace App\Http\Controllers;

use App\Exports\ProvinceExport;
use App\Exports\ProvinceFormatExport;
use App\Imports\ProvinceImport;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @OA\Tag(
 *     name="Provinces",
 *     description="Operations related to provinces"
 * )
 * @OA\Schema(
 *     schema="Province",
 *     type="object",
 *     required={"no_province", "province_name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="no_province", type="string", example="32"),
 *     @OA\Property(property="province_name", type="string", example="Jawa Barat"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */
class ProvinceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/provinces",
     *     summary="Get all provinces",
     *     tags={"Provinces"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of provinces",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Province"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Province::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/provinces",
     *     summary="Create a new province",
     *     tags={"Provinces"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"no_province", "province_name"},
     *             @OA\Property(property="no_province", type="string", example="32"),
     *             @OA\Property(property="province_name", type="string", example="Jawa Barat"),
     *         )
     *     ),
     *     @OA\Response(response=201, description="Province created successfully", @OA\JsonContent(ref="#/components/schemas/Province")),
     *     @OA\Response(response=422, description="Validation error"),
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_province' => 'required|string|max:10|unique:provinces',
            'province_name' => 'required|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            $province = Province::create($request->all());
            DB::commit();
            return response()->json($province, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/provinces/{id}",
     *     summary="Get a province by ID",
     *     tags={"Provinces"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Province details", @OA\JsonContent(ref="#/components/schemas/Province")),
     *     @OA\Response(response=404, description="Province not found"),
     * )
     */
    public function show($id)
    {
        $province = Province::findOrFail($id);
        return response()->json($province);
    }

    /**
     * @OA\Put(
     *     path="/api/provinces/{id}",
     *     summary="Update a province",
     *     tags={"Provinces"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Province")
     *     ),
     *     @OA\Response(response=200, description="Province updated successfully", @OA\JsonContent(ref="#/components/schemas/Province")),
     *     @OA\Response(response=404, description="Province not found"),
     *     @OA\Response(response=422, description="Validation error"),
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_province' => 'required|string|max:10|unique:provinces,no_province,' . $id,
            'province_name' => 'required|string|max:255'
        ]);

        $province = Province::findOrFail($id);

        DB::beginTransaction();
        try {
            $province->update($request->all());
            DB::commit();
            return response()->json($province);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/provinces/{id}",
     *     summary="Delete a province",
     *     tags={"Provinces"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Province deleted successfully"),
     *     @OA\Response(response=404, description="Province not found")
     * )
     */
    public function destroy($id)
    {
        $province = Province::findOrFail($id);

        DB::beginTransaction();
        try {
            $province->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/provinces/export-format",
     *     summary="Export Format province data",
     *     tags={"Provinces"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Excel format file exported")
     * )
     */
    public function exportFormat()
    {
        return Excel::download(new ProvinceFormatExport, 'province-format.xlsx');
    }

    /**
     * @OA\Get(
     *     path="/api/provinces/export",
     *     summary="Export province data",
     *     tags={"Provinces"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Excel file exported")
     * )
     */
    public function export()
    {
        return Excel::download(new ProvinceExport, 'provinces.xlsx');
    }

    /**
     * @OA\Post(
     *     path="/api/provinces/import",
     *     summary="Import province data from Excel",
     *     tags={"Provinces"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(@OA\Property(property="file", type="file"))
     *         )
     *     ),
     *     @OA\Response(response=200, description="Import successful")
     * )
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx'
        ]);

        Excel::import(new ProvinceImport, $request->file('file'));

        return response()->json(['message' => 'Provinsi Berhasil Diimport!'], 200);
    }
}
