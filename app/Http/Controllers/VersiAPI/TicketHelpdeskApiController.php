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
use Illuminate\Support\Facades\Http;

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

            // Inisialisasi data tiket
            $data = $validated;
            $data['no_ticket'] = $newTicketId;
            $data['level1'] = 2;
            $data['pic'] = "PIC";
            $data['status_id'] = self::STATUS_NEW;
            $data['priority_id'] = 1;
            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                $nama_file = time() . "_" . $file->getClientOriginalName();
                $file->storeAs('public/ticket', $nama_file); 
                $data['attachments'] = json_encode(["storage/ticket/$nama_file"]); // Simpan dalam format JSON
            } else {
                $data['attachments'] = json_encode([]); // Default JSON array kosong
            }
            Log::info('Data tiket yang akan disimpan', ['data' => $data]);
            $ticket = Ticket::create($data);
            DB::commit();

            Log::info('Ticket berhasil dibuat', ['ticket' => $ticket]);
            Http::post('http://localhost:4000/ticket', $ticket->toArray());

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

    public function update(Request $request, $no_ticket)
    {
        DB::beginTransaction();
        try {
            Log::info('Memulai pembaruan ticket berdasarkan no_ticket', ['request_data' => $request->all()]);

            // Temukan ticket berdasarkan no_ticket
            $ticket = Ticket::where('no_ticket', $no_ticket)->firstOrFail();

            // Update ticket dengan data dari request (bebas update apa saja)
            $ticket->update($request->all());

            // Jika ada file lampiran baru, simpan dan perbarui
            // if ($request->hasFile('attachments')) {
            //     $file = $request->file('attachments');
            //     $nama_file = time() . "_" . $file->getClientOriginalName();
            //     $file->storeAs('public/ticket', $nama_file);
            //     $ticket->attachments = json_encode(["storage/ticket/$nama_file"]); // Simpan dalam format JSON
            //     $ticket->save(); // Simpan perubahan
            // }

            DB::commit();

            Log::info('Ticket berhasil diperbarui', ['ticket' => $ticket]);

            // Kirim data tiket yang telah diperbarui ke Kafka
            Http::post('http://localhost:4000/ticket-log', [
                'data' => $ticket->toArray()
            ]);
    
            return response()->json([
                "message" => "Ticket Berhasil Diperbarui !!",
                "data" => $ticket
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Terjadi kesalahan saat memperbarui ticket', [
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

    public function logTicket($no_ticket)
    {
        try {
            $ticket = Ticket::where('no_ticket', $no_ticket)
                ->with('status')
                ->orderBy('updated_at', 'desc')
                ->get();
    
            if ($ticket->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada ticket ditemukan untuk ticket tersebut',
                    'data' => []
                ], 404);
            }
            $ticketData = ['data' => $ticket->toArray()];
            $response = Http::post('http://localhost:4000/ticket-log', $ticketData);
            if ($response->successful()) {
                return response()->json([
                    'message' => 'Log ticket berdasarkan ticket berhasil dikirim',
                    'data' => $ticket
                ]);
            } else {
                return response()->json([
                    'message' => 'Gagal mengirim log ticket ke Kafka',
                    'error' => $response->body()
                ], 500);
            }
        } catch (\Throwable $th) {
            Log::error('Gagal mengambil log ticket berdasarkan ticket', [
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil log ticket',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    


}
