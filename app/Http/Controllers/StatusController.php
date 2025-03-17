<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Status",
 *     description="Operations related to status"
 * )
 * @OA\Schema(
 *     schema="Status",
 *     type="object",
 *     required={"status_name", "color"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="status_name", type="string", example="Pending"),
 *     @OA\Property(property="color", type="string", example="#FF0000"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-17T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-17T12:00:00Z")
 * )
 */
class StatusController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/statuses",
     *     summary="Get all statuses",
     *     tags={"Statuses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of statuses",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Status"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Status::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/statuses",
     *     summary="Create a new status",
     *     tags={"Statuses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     @OA\Response(response=201, description="Status created successfully")
     * )
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $status = Status::create($request->all());
            DB::commit();
            return response()->json($status, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/statuses/{id}",
     *     summary="Update status",
     *     tags={"Statuses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     @OA\Response(response=200, description="Status updated successfully")
     * )
     */
    public function update(Request $request, $id)
    {
        $status = Status::findOrFail($id);

        DB::beginTransaction();
        try {
            $status->update($request->all());
            DB::commit();
            return response()->json($status, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/statuses/{id}",
     *     summary="Delete status",
     *     tags={"Statuses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Status deleted successfully"),
     *     @OA\Response(response=404, description="Status not found")
     * )
     */
    public function destroy($id)
    {
        $status = Status::findOrFail($id);

        DB::beginTransaction();
        try {
            $status->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
