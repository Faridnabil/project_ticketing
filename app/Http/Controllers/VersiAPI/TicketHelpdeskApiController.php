<?php

namespace App\Http\Controllers\VersiAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\CityOrRegency;
use App\Models\Province;
use App\Models\Priority;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Regional;
use App\Models\provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;

class TicketHelpdeskApiController extends Controller
{
    const STATUS_NEW = 1; 

    public function regional()
    {
        $regionalList = Regional::all();
        return response()->json([
            "message" => "Regional list",
            "outData" => $regionalList
        ], 200);
    }

    public function getProvince($regional_id)
    {
        $provinceList = provinsi::where('regional_id', $regional_id)
            ->select('id', 'name', 'code','regional_id')
            ->get();

        return response()->json([
            "message" => "Provinces List",
            "outData" => $provinceList
        ]);
    }

    public function getKabupaten($prov_id)
    {
        $kabupaten = Kabupaten::where('provinsi_id',$prov_id)->select('id','type','name')->get();
        return response()->json([
            "message" => "kabupaten list",
            "outData" => $kabupaten
        ]);

    }

    public function getKecamatan($kab_id)
    {
        $kecamatan = Kecamatan::where('kabupaten_id',$kab_id)->select('id','name','code')->get();
        return response()->json([
            "message" => "kecamatan list",
            "outData" => $kecamatan
        ]);

    }

    public function province()
    {
        return response()->json([
            "message" => "query success",
            "outData" => provinsi::select('id', 'name','regional_id')->get()
        ]);
    }

    public function kategori()
    {
        return response()->json([
            "message" => "query success",
            "outData" => Category::select('id', 'category_name')->get()
        ]);
    }

    public function city()
    {
        return response()->json([
            "message" => "query success",
            "outData" => CityOrRegency::select('id','province_id', 'city_or_regency_name')->get()
        ]);
    }

    public function priority()
    {
        return response()->json([
            "message" => "query success",
            "outData" => Priority::select('id', 'priority_name')->get()
        ]);
    }

    public function get()
    {
        return response()->json([
            "message" => "success",
            "data" => Ticket::orderBy('no_ticket', 'desc')->get()
        ]);
    }

    public function role()
    {
        $roles = Role::all();
        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            // 'priority_id' => 'required|exists:priorities,id',
            'no_hp' => 'required|string',
            'description' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            Log::info('Memulai pembuatan ticket', ['request_data' => $validated]);

            
            $lastTicketNumber = Ticket::where('no_ticket', 'LIKE', 'TICK-%')
                ->max(DB::raw("CAST(SUBSTRING(no_ticket, 6) AS UNSIGNED)"));

            $newTicketIdNumber = $lastTicketNumber ? $lastTicketNumber + 1 : 1;
            $newTicketId = 'TICK-' . str_pad($newTicketIdNumber, 6, '0', STR_PAD_LEFT);

            Log::info('Nomor tiket baru', ['no_ticket' => $newTicketId]);

            
            $data = $validated;
            $data['no_ticket'] = $newTicketId;
            $data['level1'] = 2;
            $data['pic'] = "PIC";
            $data['status_id'] = self::STATUS_NEW;
            $data['priority_id'] = 1;

            
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $nama_file = time() . "_" . $file->getClientOriginalName();
                    $filePath = $file->storeAs('ticket', $nama_file); 
                    $attachments[] = Storage::url('ticket/' . $nama_file); 
                }
            }
            $data['attachments'] = json_encode($attachments);

            Log::info('Data tiket yang akan disimpan', ['data' => $data]);

            
            $ticket = Ticket::create($data);
            DB::commit();

            Log::info('Ticket berhasil dibuat', ['ticket' => $ticket]);

            return response()->json([
                "message" => "Ticket Berhasil Dibuat !!",
                "data" => $ticket
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Terjadi kesalahan saat membuat ticket', [
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);

            return response()->json([
                "message" => "Terjadi kesalahan Pada Ticket !!",
                "error" => $th->getMessage(),
                "line" => $th->getLine(),
                "file" => $th->getFile()
            ], 500);
        }
    }

}
