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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class LandingPageController extends Controller
{
    public function index()
    {
        $tiket = Ticket::all();
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
        $serviceRoles = [];
        foreach ($service as $services) {
            foreach ($services as $item) {
                $serviceRoles[] = [
                    'id' => $services->id,
                    'name' => $services->service_name,
                    // 'category' => $item->category,
                ];
            }
        }
        // return $tiket;
        return view('landingpage.app', compact('category', 'service', 'prioritas', 'status', 'userRoles', 'users'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'no_ticket' => 'unique|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'title' => 'required',
                'name' => 'required',
                'no_telp' => 'required',
                'description' => 'required|string',
                'attachments.*' => 'file|mimes:jpg,png,pdf,docx|max:2048',
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

            //query untuk acak no ticket
            $lastTicket = Ticket::orderBy('id', 'desc')->first();
            $newTicketIdNumber = $lastTicket ? intval(substr($lastTicket->ticket_id, 5)) + 1 : 1;
            $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);
            while (Ticket::where('no_ticket', $newTicketId)->exists()) {
                $newTicketIdNumber++;
                $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);
            }

            $files = $request->file('attachments');
            $attachments = [];

            if ($files) {
                foreach ($files as $file) {
                    $nama_file = time() . "_" . $file->getClientOriginalName();
                    $nama_folder = 'file/ticket';
                    $file->move(public_path($nama_folder), $nama_file);
                    $attachments[] = $nama_folder . "/" . $nama_file;
                }
            }
            $data = new Ticket;
            $data->no_ticket = $newTicketId;
            $data->title = $request->title;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->no_telp = $request->no_telp;
            $data->assign_to = $request->assign_to;
            $data->priority_id = $request->priority_id;
            $data->due_date = null;
            $data->status_id = null;
            $data->service_id = $request->service_id;
            $data->description = $request->description;
            $data->category_id = $request->category_id;
            $data->solution = null;
            $data->status = 'Belum verifikasi';
            $data->attachments = json_encode($attachments);
            $data->status_changed_by_id = null;
            $data->save();

            DB::commit();
            // return $data;
            return Redirect::route('landing.index')->with('success', 'Tiket Berhasil Dibuat');
        } catch (\Throwable $th) {

            DB::rollBack();
            return Redirect::route('landing.index')->with('error', 'Tiket gagal dibuat');
            //throw $th;
        }
    }
}
