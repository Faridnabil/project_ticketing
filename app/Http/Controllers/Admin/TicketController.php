<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo', 'statusChangedByUser');

        if ($request->has('customer') && $request->customer) {
            $query->where('customer', $request->customer);
        }

        if ($request->has('assign_to') && $request->assign_to) {
            $query->where('assign_to', $request->assign_to);
        }

        if ($request->has('priority_id') && $request->priority_id) {
            $query->where('priority_id', $request->priority_id);
        }

        if ($request->has('status_id') && $request->status_id) {
            $query->where('status_id', $request->status_id);
        }

        $tickets = $query->get();

        // Fetch necessary data for filters
        $customers = User::role('Customer')
            ->get();
        $assign_to = User::role('Department')
            ->get();
        $priorities = Priority::all();
        $statuses = Status::all();

        return view('dashboard.admin.ticket.index', compact('tickets', 'customers', 'assign_to', 'priorities', 'statuses'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = User::role('Customer')
            ->get();

        $assignTo = User::role('Department')
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        return view(
            'dashboard.admin.ticket.create',
            compact(
                'customers',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Generate ticket_id baru
            $lastTicket = Ticket::orderBy('id', 'desc')->first();
            $newTicketIdNumber = $lastTicket ? intval(substr($lastTicket->ticket_id, 5)) + 1 : 1;
            $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);

            $validate = $request->all();
            $file = $request->file('attachment'); // pastikan nama file sesuai dengan yang di form
            $validate['no_ticket'] = $newTicketId;

            if ($file) {
                // Proses file
                $nama_file = time() . "_" . $file->getClientOriginalName();
                $nama_folder = 'file/ticket';
                $file->move(public_path($nama_folder), $nama_file);
                $validate['attachment'] = $nama_folder . "/" . $nama_file;
            }

            Ticket::create($validate);

            DB::commit();
            return redirect()->route('ticket.index')->with('success', 'Tiket Berhasil Dibuat.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);
        $customers = User::role('Customer')
            ->get();

        $assignTo = User::role('Department')
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $statusChangedBy = Auth::user();

        $logs = ActivityLog::where('model_type', Ticket::class)
            ->where('model_id', $ticket->id)
            ->latest()
            ->get();

        $comments = Comment::where('ticket_id', $id)
            ->with('user')
            ->get();

        return view(
            'dashboard.admin.ticket.show',
            compact(
                'ticket',
                'logs',
                'customers',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
                'comments',
                'statusChangedBy'
            )
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $customers = User::role('Customer')
            ->get();

        $assignTo = User::role('Department')
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $statusChangedBy = Auth::user();

        $logs = ActivityLog::where('model_type', Ticket::class)
            ->where('model_id', $ticket->id)
            ->get();

        return view(
            'dashboard.admin.ticket.edit',
            compact(
                'ticket',
                'customers',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
                'statusChangedBy',
                'logs',
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'title' => 'required',
            'customer' => 'required',
            'assign_to' => 'required',
            'priority_id' => 'required',
            'due_date' => 'nullable|date',
            'status_id' => 'required',
            'category_id' => 'required',
            'description' => 'nullable',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'reason' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $validate = $request->all();
            if ($request->hasFile('attachment')) {
                // Proses file baru
                $file = $request->file('attachment');
                $nama_file = time() . "_" . $file->getClientOriginalName();
                $nama_folder = 'file/ticket';
                $file->move(public_path($nama_folder), $nama_file);
                $validate['attachment'] = $nama_folder . "/" . $nama_file;

                // Hapus file lama jika ada
                if ($ticket->attachment && file_exists(public_path($ticket->attachment))) {
                    unlink(public_path($ticket->attachment));
                }
            }

            $ticket->update($validate);

            DB::commit();
            return redirect()->route('ticket.index')->with('success', 'Tiket Berhasil Dirubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        try {
            if (!$ticket) {
                // Jika principle tidak ditemukan, kembalikan pesan kesalahan
                return back()->with(['error' => 'Tiket Tidak ada.']);
            }

            $ticket->delete(); // Hapus principle
            return redirect()->route('ticket.index')->with('success', 'Tiket Berhasil dihapus');
        } catch (\Throwable $th) {
            // Log activity
            return back()->with('error', 'Tiket gagal dihapus');
        }
    }
}
