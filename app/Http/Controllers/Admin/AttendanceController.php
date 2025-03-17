<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *     name="Attendance",
 *     description="Operations related to attendance records"
 * )
 *
 * @OA\Schema(
 *     schema="Attendance",
 *     type="object",
 *     required={"user_id", "check_in", "date_check_in"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="check_in", type="string", example="08:00"),
 *     @OA\Property(property="date_check_in", type="string", format="date", example="2024-03-17"),
 *     @OA\Property(property="check_out", type="string", example="17:00"),
 *     @OA\Property(property="date_check_out", type="string", format="date", example="2024-03-17"),
 *     @OA\Property(property="activity", type="string", example="Working on project"),
 *     @OA\Property(property="attachment", type="string", format="binary")
 * )
 */
class AttendanceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/attendance",
     *     summary="Get all attendance records",
     *     tags={"Attendance"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of attendance records")
     * )
     */
    public function index(Request $request)
    {
        $attendances = Attendance::all();
        return response()->json($attendances);
    }

    /**
     * @OA\Post(
     *     path="/api/attendance",
     *     summary="Create a new attendance record",
     *     tags={"Attendance"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Attendance")
     *     ),
     *     @OA\Response(response=201, description="Attendance record created successfully")
     * )
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = $request->all();
            $validate['date_check_in'] = now();
            $attendance = Attendance::create($validate);
            DB::commit();
            return response()->json($attendance, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/attendance/{id}",
     *     summary="Update an attendance record",
     *     tags={"Attendance"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Attendance")
     *     ),
     *     @OA\Response(response=200, description="Attendance record updated successfully")
     * )
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        DB::beginTransaction();
        try {
            $attendance->update($request->all());
            DB::commit();
            return response()->json($attendance);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/attendance/{id}",
     *     summary="Delete an attendance record",
     *     tags={"Attendance"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Attendance record deleted successfully")
     * )
     */
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);

        DB::beginTransaction();
        try {
            $attendance->delete();
            DB::commit();
            return response()->json(['message' => 'Attendance record deleted successfully']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
