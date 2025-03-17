<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Priorities",
 *     description="Operations related to priorities"
 * )
 * @OA\Schema(
 *     schema="Priority",
 *     type="object",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="priority_name", type="string", example="High"),
 *     @OA\Property(property="color", type="string", example="#ff0000"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */
class PriorityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/priorities",
     *     summary="Get all priorities",
     *     tags={"Priorities"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of priorities",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Priority")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $priorities = Priority::all();

        return response()->json($priorities, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/priorities",
     *     summary="Create a new priority",
     *     tags={"Priorities"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"priority_name", "color"},
     *             @OA\Property(property="priority_name", type="string", example="High"),
     *             @OA\Property(property="color", type="string", example="#ff0000"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Priority created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Priority")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'priority_name' => 'required|string|max:255',
            'color' => 'required|string|max:7'
        ]);

        DB::beginTransaction();
        try {
            $priority = Priority::create($request->all());
            DB::commit();
            return response()->json($priority, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/priorities/{id}",
     *     summary="Update a priority",
     *     tags={"Priorities"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"priority_name", "color"},
     *             @OA\Property(property="priority_name", type="string", example="Updated High"),
     *             @OA\Property(property="color", type="string", example="#ff6600"),
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Priority updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Priority")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Priority not found",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'priority_name' => 'required|string|max:255',
            'color' => 'required|string|max:7'
        ]);

        $priority = Priority::findOrFail($id);

        DB::beginTransaction();
        try {
            $priority->update($request->all());
            DB::commit();
            return response()->json($priority);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/priorities/{id}",
     *     summary="Delete a priority",
     *     tags={"Priorities"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Priority deleted successfully"),
     *     @OA\Response(response=404, description="Priority not found")
     * )
     */
    public function destroy($id)
    {
        $priority = Priority::findOrFail($id);

        DB::beginTransaction();
        try {
            $priority->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
