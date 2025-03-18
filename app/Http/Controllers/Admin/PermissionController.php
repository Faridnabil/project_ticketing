<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Permissions",
 *     description="API for managing permissions"
 * )
 */
class PermissionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/permissions",
     *     summary="Get all permissions",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of permissions")
     * )
     */
    public function index()
    {
        return response()->json(Permission::all());
    }

    /**
     * @OA\Post(
     *     path="/api/permissions",
     *     summary="Create a new permission",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="manage-users")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Permission created successfully"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $permission = Permission::create($request->only('name'));

        return response()->json($permission, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/permissions/{id}",
     *     summary="Update an existing permission",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="edit-posts")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Permission updated successfully"),
     *     @OA\Response(response=404, description="Permission not found"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json(['message' => 'Permission not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $permission->update($request->only('name'));

        return response()->json($permission);
    }

    /**
     * @OA\Delete(
     *     path="/api/permissions/{id}",
     *     summary="Delete a permission",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Permission deleted successfully"),
     *     @OA\Response(response=404, description="Permission not found")
     * )
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json(['message' => 'Permission not found'], 404);
        }

        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully']);
    }
}
