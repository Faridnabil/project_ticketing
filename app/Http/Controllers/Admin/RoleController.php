<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
{
    public function index(Request $request)
    {
        //menampilkan semua data role
        $roles = Role::all();

        $permission = Permission::paginate(6);
        return view('dashboard.admin.user-management.role.index', compact('roles', 'permission'));
    }

    public function create()
    {
        $permission = Permission::get();

        return view('dashboard.admin.user-management.role.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'regex:/^[^0-9!@#$%^&*(),.?":{}|<>]+$/'],
        ], [
            'name.required' => 'The name field is required. or do not use characters',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions(array_map(fn($val)=>(int)$val, $request->input('permission')));

        return redirect('role')->with('success', 'Role created successfully');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('dashboard.admin.user-management.role.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'regex:/^[^0-9!@#$%^&*(),.?":{}|<>]+$/'],
        ], [
            'name.required' => 'The name field is required. or do not use characters',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        // $role->syncPermissions($request->input('permission'));
        $role->syncPermissions(array_map(fn($val)=>(int)$val, $request->input('permission')));

        return redirect('role')->with('success', 'Role updated successfully');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect('role')->with('success', 'Role deleted successfully');
    }
}
