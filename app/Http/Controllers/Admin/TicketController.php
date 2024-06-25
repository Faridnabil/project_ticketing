<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('status', 'category', 'priority', 'customer', 'assignTo', 'statusChangedByUser')
            ->get();

        return view('dashboard.admin.ticket.index', compact('tickets'));
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
    public function store(StoreTicketRequest $request)
    {
        DB::beginTransaction();
        try {
            // Generate ticket_id baru
            $lastTicket = Ticket::orderBy('id', 'desc')->first();
            $newTicketIdNumber = $lastTicket ? intval(substr($lastTicket->ticket_id, 5)) + 1 : 1;
            $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);

            $validate = $request->all();
            $validate['no_ticket'] = $newTicketId;

            $ticket = Ticket::create($validate);

            DB::commit();
            return redirect()->route('ticket.index')->with('success', 'Tiket Berhasil Dibuat.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('dashboard.admin.ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $customer = User::role('Customer')
            ->get();

        $assignTo = User::role('Department')
            ->get();

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        $statusChangedBy = Auth::user();

        return view(
            'dashboard.admin.ticket.edit',
            compact(
                'ticket',
                'customer',
                'assignTo',
                'priorities',
                'statuses',
                'categories',
                'statusChangedBy'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        DB::beginTransaction();
        try {
            $ticket->update($request->all());

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
        DB::beginTransaction();
        try {
            $ticket->delete();

            DB::commit();
            return redirect()->route('ticket.index')->with('success', 'Tiket Berhasil Dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}
