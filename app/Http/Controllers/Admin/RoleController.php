<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Roles",
 *     description="API for managing roles"
 * )
 */
class RoleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Get list of roles",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Successful operation"),
     * )
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return response()->json([
            'message' => 'Roles retrieved successfully',
            'data' => $roles
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Create a new role",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Admin"),
     *             @OA\Property(property="permissions", type="array", @OA\Items(type="integer"))
     *         )
     *     ),
     *     @OA\Response(response=201, description="Role created successfully"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::transaction(function () use ($request) {
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permissions'));
        });

        return response()->json(['message' => 'Role created successfully'], 201);
    }


    /**
     * @OA\Get(
     *     path="/api/roles/{id}",
     *     summary="Get a specific role",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Role not found")
     * )
     */
    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return response()->json([
            'message' => 'Role retrieved successfully',
            'data' => $role
        ], 200);
    }


    /**
     * @OA\Put(
     *     path="/api/roles/{id}",
     *     summary="Update a role",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Manager"),
     *             @OA\Property(property="permissions", type="array", @OA\Items(type="integer"))
     *         )
     *     ),
     *     @OA\Response(response=200, description="Role updated successfully"),
     *     @OA\Response(response=404, description="Role not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::transaction(function () use ($request, $id) {
            $role = Role::findOrFail($id);
            $role->update(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permissions'));
        });

        return response()->json(['message' => 'Role updated successfully'], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/roles/{id}",
     *     summary="Delete a role",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Role deleted successfully"),
     *     @OA\Response(response=404, description="Role not found")
     * )
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->delete();
        return response()->json(null, 204);
    }
}
