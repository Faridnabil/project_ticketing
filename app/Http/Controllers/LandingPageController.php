<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Priority;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use App\Models\Status;
use App\Models\Role;
use DB;

class LandingPageController extends Controller
{
    public function index()
    {
        $category = Category::all();
        $service = Service::all();
        $prioritas = Priority::all();
        $status = Status::all();
        $users = User::all();
        $role = Role::all();
        $userRoles = [];
        foreach ($users as $user) {
            foreach ($user->roles as $role) {
                $userRoles[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $role->name,
                ];
            }
        }
        $serviceRoles= [];
        foreach ($service as $services) {
            foreach ($services as $item) {
                $serviceRoles[] = [
                    'id' => $services->id,
                    'name' => $services->service_name,
                    // 'category' => $item->category,
                ];
            }
        }
        // return $serviceRoles;
        return view('landingpage.app', compact('category','service', 'prioritas','status', 'userRoles','users'));
    }

    public function store(Request $request)
    {

    }

}
