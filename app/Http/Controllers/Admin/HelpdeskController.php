<?php


namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpdesk;
use App\Exports\HelpdesksExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Requests\MassDestroyCommentRequest;
use App\Http\Requests\MassDestroyHelpdeskRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Priority;
use App\Status;
use App\Ticket;
use App\User;
use Gate;
use Symfony\Component\HttpFoundation\Response;



class HelpdeskController extends Controller
{
    public function index()
    {
        $helpdesks = Helpdesk::All();
        // $tickets = Ticket::All();
        return view('admin.helpdesks.index', compact('helpdesks'));
    }

    public function export()
    {
        return Excel::download(new HelpdesksExport(), 'helpdesks.xlsx');
    }

    public function cetak_pdf()
    {
    	$helpdesks = Helpdesk::all();
 
    	$pdf = PDF::loadview('admin.helpdesks.helpdesk_pdf',['helpdesks'=>$helpdesks])->setPaper('a4', 'landscape');
    	return $pdf->stream();
    }
    public function create()
    {
        abort_if(Gate::denies('helpdesk_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $priorities = Priority::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $tickets = Ticket::all();
        $statuses = Status::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $statuses = Status::all()->pluck('name', 'id');
        // $openStatusId = Status::where('name', 'Open')->first()->id;
        $openStatusId = Status::where('name', 'Open')->first()->id; // Ambil ID status "Open"
        $closedStatusId = Status::where('name', 'Closed')->first()->id; // Ambil ID status "Closed"
        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.helpdesks.create', compact('priorities', 'tickets', 'statuses', 'users', 'openStatusId', 'closedStatusId'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'email_address' => 'required|string|max:255',
            'message' => 'required|string',
            'priority_id' => 'required',
            'ticket_id' => 'required',
            // 'category_id' => 'required',
            'user_id' => 'required',
            // tambahkan validasi untuk user_id jika diperlukan
        ]);
        $helpdesk = new Helpdesk();
        $lowLevel1PriorityId = Priority::where('name', 'Low / Level 1')->value('id');
        // Get the ID of the "Closed" status
        $closedStatusId = Status::where('name', 'Closed')->value('id');
        $openStatusId = Status::where('name', 'Open')->value('id');
        // Set the status to "Closed" if the priority is "Low / Level 1"
        if ($request->input('priority_id') == $lowLevel1PriorityId) {
            $helpdesk->status_id = $closedStatusId;
        } else {
            $helpdesk->status_id = $openStatusId;
        }

        // Tetapkan status_id ke ID dari status "Open"
        // Misalnya, kita asumsikan ID dari status "Open" adalah 1
        $openStatusId = Status::where('name', 'Open')->first()->id;
        $validatedData['status_id'] = $openStatusId;

        // Simpan data ke database
        Helpdesk::create($validatedData);

        return redirect()->route('admin.helpdesks.index')->with('success', 'Helpdesk created successfully');
    }

//     public function store(Request $request)
// {
//     $helpdesk = new Helpdesk();
//     $helpdesk->subject = $request->input('subject');
//     $helpdesk->email_address = $request->input('email_address');
//     $helpdesk->message = $request->input('message');
//     $helpdesk->priority_id = $request->input('priority_id');
//     $helpdesk->user_id = $request->input('user_id');
//     $lowLevel1PriorityId = Priority::where('name', 'Low / Level 1')->value('id');
//     // Get the ID of the "Closed" status
//     $closedStatusId = Status::where('name', 'Closed')->value('id');
//     $openStatusId = Status::where('name', 'Open')->value('id');
//     // Set the status to "Closed" if the priority is "Low / Level 1"
//     if ($request->input('priority_id') == $lowLevel1PriorityId) {
//         $helpdesk->status_id = $closedStatusId;
//     } else {
//         $helpdesk->status_id = $openStatusId;
//     }
//     $helpdesk->create();

//     return redirect()->route('admin.helpdesks.index');
// }



    public function show(Helpdesk $helpdesk)
    {
        return view('admin.helpdesks.show', compact('helpdesk'));
    }

    public function edit(Helpdesk $helpdesk)
    {
        $priorities = Priority::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $categories = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $tickets = Ticket::all();
        $statuses = Status::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.helpdesks.edit', compact('helpdesk', 'priorities', 'statuses', 'tickets', 'users'));
    }

    public function update(Request $request, Helpdesk $helpdesk)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'email_address' => 'required|string|max:255',
            'message' => 'required|string',
            'priority_id' => 'required',
            'ticket_id' => 'required',
            // 'category_id' => 'required',
            'user_id' => 'required',
            'status_id' => 'required',
            // tambahkan validasi untuk user_id jika diperlukan
        ]);

        // Tambahkan user_id ke data yang akan disimpan
        // $validatedData['user_id'] = auth()->id();


        $helpdesk->update($request->all());

        return redirect()->route('admin.helpdesks.index')->with('success', 'Helpdesk updated successfully');
    }

    public function destroy(Helpdesk $helpdesk)
    {
        $helpdesk->delete();

        return redirect()->route('admin.helpdesks.index')->with('success', 'Helpdesk deleted successfully');
    }

    public function close($id)
    {
        $helpdesk = Helpdesk::findOrFail($id);
        $statusClosed = Status::where('name', 'closed')->first();

        if ($statusClosed) {
            $helpdesk->status_id = $statusClosed->id;
            $helpdesk->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
    public function massDestroy(MassDestroyHelpdeskRequest $request)
    {
        Priority::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
