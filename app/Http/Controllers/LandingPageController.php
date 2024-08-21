<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Priority;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use App\Models\Status;
use App\Models\Role;
use App\Models\Ticket;
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
        $request->validate([
            'no_ticket' =>'unique|string|max:255',
            'email' =>'required|string|email|max:255|unique:users',
            'title' => 'required',
            'name' => 'required',
            'no_telp' => 'required',
            'description' => 'required|string',
            // 'attachments' => 'required|file:jpg,png,xlsx,pdf,docx|max:2048',
        ],[
            'title.required' => 'tolong isi dengan benar',
            'email.required' => 'isi dengan email aktif',
            'name.required' => 'isi dengan nama asli atau nama panggilan',
        ]);

        $lastTicket = Ticket::orderBy('id', 'desc')->first();
        $newTicketIdNumber = $lastTicket ? intval(substr($lastTicket->ticket_id, 5)) + 1 : 1;
        $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);
        while (Ticket::where('no_ticket', $newTicketId)->exists()) {
            $newTicketIdNumber++;
            $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);
        }

        $data = new Ticket;
        $data -> no_ticket = $newTicketId;
        $data -> title = $request->title;
        $data -> name = $request->name;
        $data -> email = $request->email;
        $data -> no_telp = $request->no_telp;
        $data -> assign_to = 1;
        $data -> priority_id = 1;
        $data -> due_date = null;
        $data -> status_id = 1;
        $data -> service_id = 1;
        $data -> description = $request->description;
        $data -> category_id =1;
        $data -> solution = null;
        $data -> attachments = null;
        $data -> status_changed_by_id = null;

        return $data;

    }

}
