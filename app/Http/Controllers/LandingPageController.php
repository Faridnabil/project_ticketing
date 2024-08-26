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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    public function index()
    {
        $tiket = Ticket::all();
        $categories = Category::all();
        $services = Service::all();
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
        // $userRoles = collect($userRoles)->unique('role')->values()->all();
        $desiredRoles = ['SysAdmin', 'DBA', 'Engineer'];
        $userRoles = collect($userRoles)
            ->unique('role')
            ->filter(function ($item) use ($desiredRoles) {
                return in_array($item['role'], $desiredRoles);
            })
            ->values()->all();
        // return $tiket;
        return view('landingpage.app', compact('categories', 'services', 'prioritas', 'status', 'userRoles', 'users'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                // 'no_ticket' => 'unique|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'title' => 'required',
                'name' => 'required',
                'no_telp' => 'required',
                'description' => 'required|string',
                'attachments.*' => 'file|mimes:jpg,png,pdf,docx|max:5120',
            ], [
                'title.required' => 'tolong isi dengan benar',
                'email.required' => 'isi dengan email aktif',
                'name.required' => 'isi dengan nama asli atau nama panggilan',
                'attachments.required' => 'maksimal file berukuran 5MB',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->with('errorForm', $validator->errors()->getMessages())
                    ->withInput();
            }

            $lastTicket = Ticket::orderBy('id', 'desc')->first();
            $newTicketIdNumber = $lastTicket ? intval(substr($lastTicket->ticket_id, 5)) + 1 : 1;
            $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);
            while (Ticket::where('no_ticket', $newTicketId)->exists()) {
                $newTicketIdNumber++;
                $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);
            }

            $images = array();
            if ($request->hasFile('attachments')) {
                $files = $request->file('attachments');
                foreach ($files as $file) {
                    $image_name = md5(rand(1000, 10000));
                    $ext = strtolower($file->getClientOriginalExtension());
                    $image_full_name = $image_name . '.' . $ext;
                    $path = $file->storeAs('ticket', $image_full_name, 'public');
                    $images[] = $path;
                }
            }

            $data = new Ticket;
            $data->no_ticket = $newTicketId;
            $data->title = $request->title;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->no_telp = $request->no_telp;
            if (!$request->assign_to) {
                $selectedRole = $request->input('assig_to_role');
                $users = User::whereHas('roles', function ($query) use ($selectedRole) {
                    $query->where('name', $selectedRole);
                })->get();
                if ($users->isEmpty()) {
                    return redirect()->back()->withErrors(['error' => 'Tidak ada pengguna yang memiliki role tersebut.']);
                }
                foreach ($users as $user) {
                    $dataClone = clone $data;
                    $dataClone->assign_to = $user->id;
                    $dataClone->priority_id = $request->priority_id;
                    $dataClone->due_date = null;
                    $dataClone->status_id = null;
                    $dataClone->service_id = $request->service_id;
                    $dataClone->description = $request->description;
                    $dataClone->description = strip_tags($request->description);
                    $dataClone->category_id = $request->category_id;
                    $dataClone->solution = null;
                    $dataClone->status = 'Belum verifikasi';
                    $dataClone->attachments = json_encode($images);
                    $dataClone->status_changed_by_id = null;
                    $dataClone->save();
                }
            } else {
                $data->assign_to = $request->assign_to;
                $data->priority_id = $request->priority_id;
                $data->due_date = null;
                $data->status_id = null;
                $data->service_id = $request->service_id;
                $data->description = $request->description;
                $data->description = strip_tags($request->description);
                $data->category_id = $request->category_id;
                $data->solution = null;
                $data->status = 'Belum verifikasi';
                $data->attachments = json_encode($images);
                $data->status_changed_by_id = null;
                $data->save();
            }
            DB::commit();
            Log::info('Data to be saved:', ['data' => $data]);
            Log::info('Images:', ['images' => $images]);
            // return $data;
            // dd($request->file('attachments'));
            return Redirect::route('landing.index')->with('success', 'Tiket Berhasil Dibuat');
        } catch (\Throwable $th) {

            DB::rollBack();
            return Redirect::route('landing.index')->with('error', 'Tiket gagal dibuat');
            //throw $th;
        }
    }

    public function getCategoriesByService($service_id)
    {
        $categories = Category::where('layanan_id', $service_id)->get();
        return response()->json($categories);
    }

    public function getUserRoles()
    {
        $roles = User::with('roles')->get()->flatMap(function ($user) {
            return $user->roles->pluck('name');
        })->unique();
        return response()->json($roles);
    }

    public function getUsersByDivision($division)
    {
        $users = User::with('roles')
        ->whereHas('roles', function($query) use ($division) {
            $query->where('name', $division);
        })
        ->get();
        Log::info('Users:', ['users' => $users]);
        return response()->json($users);
    }

    function backup()
    {
            // $data = new Ticket;
            // $data->no_ticket = $newTicketId;
            // $data->title = $request->title;
            // $data->name = $request->name;
            // $data->email = $request->email;
            // $data->no_telp = $request->no_telp;
            // // $data->assign_to = $request->assign_to;

            // if (!$request->assign_to) {
            //     $selectedRole = $request->input('assig_to_role');
            //     $assignedUser = User::whereHas('roles', function ($query) use ($selectedRole) {
            //         $query->where('name', $selectedRole);
            //     })->first();
            //     if ($assignedUser) {
            //         $data->assign_to = $assignedUser->id;
            //     } else {
            //         return redirect()->back()->withErrors(['error' => 'Tidak ada pengguna yang memiliki role tersebut.']);
            //     }
            // } else {
            //     $data->assign_to = $request->assign_to;
            // }            
            // $data->priority_id = $request->priority_id;
            // $data->due_date = null;
            // $data->status_id = null;
            // $data->service_id = $request->service_id;
            // $data->description = $request->description;
            // $data->category_id = $request->category_id;
            // $data->solution = null;
            // $data->status = 'Belum verifikasi';
            // $data->attachments = json_encode($images);
            // $data->status_changed_by_id = null;
            // $data->save();

    }

        
}
