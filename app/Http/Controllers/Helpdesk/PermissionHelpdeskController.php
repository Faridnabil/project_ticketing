<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionHelpdeskController extends Controller
{
    public function index(Request $request)
    {
        $permissions = Permission::all();

        return view('dashboard.helpdesk.user-management.permission.index', compact('permissions'));
    }

    public function create()
    {
        $permission = Permission::pluck('name', 'name')->all();
        return view('dashboard.helpdesk.user-management.permission.create', compact('permission'));
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

        $input = $request->all();
        Permission::create($input);

        return redirect('helpdesk/permission')->with('success', 'Permission created successfully');
    }

    public function edit($id)
    {
        $permission = Permission::find($id);

        return view('dashboard.helpdesk.user-management.permission.edit', compact('permission'));
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

        $input = $request->all();

        $permission = Permission::find($id);
        $permission->update($input);

        return redirect('helpdesk/permission')->with('success', 'Permission updated successfully');
    }

    public function destroy($id)
    {
        Permission::find($id)->delete();
        return redirect('helpdesk/permission')->with('success', 'Permission deleted successfully');
    }
}
