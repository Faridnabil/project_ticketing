<?php


namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpdesk;


use App\Http\Requests\MassDestroyCommentRequest;
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
        return view('admin.helpdesks.index', compact('helpdesks'));
    }

    public function create()
    {
        abort_if(Gate::denies('helpdesk_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $priorities = Priority::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $categories = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $statuses = Status::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.helpdesks.create', compact('priorities','statuses', 'users'));
    }

    public function store(Request $request)
    {
        
         // Validasi data
    $validatedData = $request->validate([
        'subject' => 'required|string|max:255',
        'email_address' => 'required|string|max:255',
        'message' => 'required|string',
        'priority_id' => 'required',
        // 'category_id' => 'required',
        'user_id' => 'required',
        'status_id' => 'required',
        // tambahkan validasi untuk user_id jika diperlukan
    ]);

    // Tambahkan user_id ke data yang akan disimpan
    $validatedData['user_id'] = auth()->id();

    // Simpan data ke database
    Helpdesk::create($validatedData);


        return redirect()->route('admin.helpdesks.index')->with('success', 'Helpdesk created successfully');
    }

    public function show(Helpdesk $helpdesk)
    {
        return view('admin.helpdesks.show', compact('helpdesk'));
    }

    public function edit(Helpdesk $helpdesk)
    {
        $priorities = Priority::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $categories = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $statuses = Status::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.helpdesks.edit', compact('helpdesk','priorities','statuses', 'users'));
    }

    public function update(Request $request, Helpdesk $helpdesk)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'email_address' => 'required|string|max:255',
            'message' => 'required|string',
            'priority_id' => 'required',
            // 'category_id' => 'required',
            'user_id' => 'required',
            'status_id' => 'required',
            // tambahkan validasi untuk user_id jika diperlukan
        ]);
    
        // Tambahkan user_id ke data yang akan disimpan
        $validatedData['user_id'] = auth()->id();
    

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
}
