<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Faq;
use App\Models\FaqChatLog;
use App\Models\FaqUnansweredQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\IOFactory;

class FaqManagementController extends Controller
{
    /**
     * Display a listing of FAQ templates.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $query = Faq::with('creator')->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if (!empty($category)) {
            $query->where('category', $category);
        }

        $faqs = $query->get();
        $masterCategories = Category::pluck('category_name')->filter();
        $faqCategories = Faq::distinct()->pluck('category')->filter();
        $categories = $masterCategories->merge($faqCategories)->unique()->values();

        // Get unanswered questions count and list for template suggestion tab
        $unansweredCount = FaqUnansweredQuestion::where('status', 'pending')->count();
        $unansweredQuestions = FaqUnansweredQuestion::where('status', 'pending')
            ->orderBy('occurrence_count', 'desc')
            ->latest('updated_at')
            ->get();

        // Attach related users who asked each unanswered question
        $unansweredQuestionTexts = $unansweredQuestions->pluck('question')->toArray();
        $chatLogsForUnanswered = FaqChatLog::whereIn('question', $unansweredQuestionTexts)
            ->with('user')
            ->latest('id')
            ->get()
            ->groupBy('question');

        foreach ($unansweredQuestions as $item) {
            $relatedLogs = $chatLogsForUnanswered->get($item->question, collect());
            $item->related_users = $relatedLogs->pluck('user')->filter()->unique('id')->values();
            $item->last_user = $relatedLogs->first() ? $relatedLogs->first()->user : null;
            $item->last_asked_at = $relatedLogs->first() ? $relatedLogs->first()->created_at : $item->updated_at;
        }

        return view('dashboard.admin.faq.index', compact('faqs', 'categories', 'unansweredCount', 'unansweredQuestions', 'search', 'category'));
    }

    /**
     * Store a newly created FAQ in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:100',
            'keywords' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        Faq::create([
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'category' => $request->input('category') ?: 'Umum',
            'keywords' => $request->input('keywords'),
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : true,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.faq.index')->with('success', 'Template FAQ berhasil ditambahkan.');
    }

    /**
     * Update the specified FAQ in storage.
     */
    public function update(Request $request, int $id)
    {
        $faq = Faq::findOrFail($id);

        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:100',
            'keywords' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $faq->update([
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'category' => $request->input('category') ?: 'Umum',
            'keywords' => $request->input('keywords'),
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : false,
        ]);

        return redirect()->route('admin.faq.index')->with('success', 'Template FAQ berhasil diperbarui.');
    }

    /**
     * Toggle the active status of an FAQ item.
     */
    public function toggleActive(int $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->is_active = !$faq->is_active;
        $faq->save();

        $statusText = $faq->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "FAQ berhasil {$statusText}.");
    }

    /**
     * Remove the specified FAQ from storage.
     */
    public function destroy(int $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')->with('success', 'Template FAQ berhasil dihapus.');
    }

    /**
     * Convert an unanswered / AI question into a formal FAQ template.
     */
    public function convertUnanswered(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:100',
            'keywords' => 'nullable|string|max:255',
            'unanswered_id' => 'nullable|integer',
            'chat_log_id' => 'nullable|integer',
        ]);

        Faq::create([
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'category' => $request->input('category') ?: 'Umum',
            'keywords' => $request->input('keywords'),
            'is_active' => true,
            'created_by' => Auth::id(),
        ]);

        $chatLogId = $request->input('chat_log_id');
        if ($chatLogId) {
            $log = FaqChatLog::find($chatLogId);
            if ($log) {
                $log->update(['is_reviewed' => true, 'reviewed_at' => now()]);
            }
        }

        $unansweredId = $request->input('unanswered_id');
        if ($unansweredId) {
            $unanswered = FaqUnansweredQuestion::find($unansweredId);
            if ($unanswered) {
                $unanswered->update(['status' => 'converted']);
            }
        }
        FaqUnansweredQuestion::where('question', $request->input('question'))->update(['status' => 'converted']);

        return redirect()->back()->with('success', 'Pertanyaan berhasil diubah menjadi Solusi FAQ resmi!');
    }

    /**
     * Delete an unanswered question from the queue.
     */
    public function deleteUnanswered(int $id)
    {
        $unanswered = FaqUnansweredQuestion::findOrFail($id);
        $unanswered->delete();

        return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus dari antrean.');
    }

    /**
     * Download structured import template in Excel (.xlsx) or CSV format.
     */
    public function downloadTemplate(Request $request)
    {
        $format = strtolower($request->query('format', 'xlsx'));

        $headers = ['Pertanyaan', 'Jawaban Solusi', 'Kategori', 'Kata Kunci'];
        $sampleData = [
            [
                'Bagaimana cara mengatasi gagal login atau lupa password akun SIAK?',
                'Silakan buka portal SIAK Terpusat, klik "Lupa Password" atau hubungi Administrator Helpdesk Dukcapil untuk reset kata sandi akun Anda.',
                'Aplikasi SIAK Terpusat',
                'login, password, lupa password, reset password, siak, akun terkunci'
            ],
            [
                'Aplikasi SIAK Terpusat lambat atau muncul pesan Network Timeout, apa yang harus dilakukan?',
                'Periksa koneksi VPN/Jarkomdat Dukcapil. Pastikan indikator koneksi aktif dan lakukan tes ping ke gateway SIAK sebelum mengajukan tiket kendala jaringan.',
                'Jarkomdat',
                'timeout, jaringan lambat, vpn, jarkomdat, putus koneksi, internet'
            ],
            [
                'Bagaimana prosedur pengajuan aktivasi akun Identitas Kependudukan Digital (IKD)?',
                'Unduh aplikasi IKD dari Play Store/App Store, lakukan pendaftaran data diri, lalu datangi kantor Disdukcapil setempat untuk melakukan scan QR aktivasi dan verifikasi wajah (Face Recognition).',
                'IKD',
                'aktivasi ikd, scan qr, identitas digital, registrasi ikd, face recognition'
            ],
            [
                'Bagaimana cara permohonan penggantian Ribbon atau perbaikan printer cetak KTP-el?',
                'Buat tiket pada menu Aplikasi Tiket dengan kategori KTP Elektronik. Sertakan nomor seri printer, foto kondisi fisik alat, dan jumlah kebutuhan ribbon cetak.',
                'KTP Elektronik',
                'cetak ktp, ribbon habis, printer rusak, blanko ktp, alat cetak'
            ],
            [
                'Bagaimana jika dokumen kependudukan gagal ditandatangani secara elektronik (TTE)?',
                'Pastikan sertifikat elektronik BSrE masih aktif. Jika status BSrE sedang maintenance, tunggu beberapa saat atau ajukan tiket kendala TTE/Layanan.',
                'TTE/Layanan',
                'tte, tanda tangan elektronik, bsre, gagal tte, sertifikat kedaluwarsa'
            ],
        ];

        if ($format === 'csv') {
            $filename = 'template_import_faq.csv';
            return response()->streamDownload(function () use ($headers, $sampleData) {
                $output = fopen('php://output', 'w');
                // UTF-8 BOM so Excel opens with proper encoding
                fputs($output, "\xEF\xBB\xBF");
                fputcsv($output, $headers);
                foreach ($sampleData as $row) {
                    fputcsv($output, $row);
                }
                fclose($output);
            }, $filename, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        // Generate genuine XLSX file
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template FAQ');

        // Headers
        $sheet->fromArray($headers, null, 'A1');

        // Header Styling
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '002147']
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
        ];
        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Data rows
        $sheet->fromArray($sampleData, null, 'A2');

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(26);
        $sheet->getColumnDimension('D')->setWidth(42);

        $sheet->getStyle('A2:D' . (count($sampleData) + 1))
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_TOP);

        // Sheet 2: Panduan Kategori Resmi dari Database
        $catSheet = $spreadsheet->createSheet();
        $catSheet->setTitle('Daftar Kategori Resmi');
        $catSheet->fromArray(['Kode', 'Nama Kategori', 'Keterangan'], null, 'A1');
        $catSheet->getStyle('A1:C1')->applyFromArray($headerStyle);
        $catSheet->getRowDimension(1)->setRowHeight(28);

        $dbCategories = Category::all(['code', 'category_name', 'description']);
        $catRows = [];
        foreach ($dbCategories as $cat) {
            $catRows[] = [$cat->code ?? '-', $cat->category_name, $cat->description ?? '-'];
        }
        $catSheet->fromArray($catRows, null, 'A2');
        $catSheet->getColumnDimension('A')->setWidth(15);
        $catSheet->getColumnDimension('B')->setWidth(30);
        $catSheet->getColumnDimension('C')->setWidth(60);
        $catSheet->getStyle('A2:C' . (count($catRows) + 1))->getAlignment()->setWrapText(true);

        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        $filename = 'template_import_faq.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Import FAQs from uploaded Excel (.xlsx, .xls) or CSV file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt',
        ]);

        $file = $request->file('file');

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, false);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membaca berkas: ' . $e->getMessage());
        }

        if (empty($rows) || count($rows) < 2) {
            return redirect()->back()->with('error', 'Berkas kosong atau tidak memiliki data.');
        }

        // Header detection (skip first row if it contains header keywords)
        $firstRow = $rows[0];
        $startIdx = 0;
        $headerCheck = strtolower(implode(' ', array_filter($firstRow)));
        if (str_contains($headerCheck, 'pertanyaan') || str_contains($headerCheck, 'question')) {
            $startIdx = 1;
        }

        $imported = 0;
        $failed = 0;

        for ($i = $startIdx; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (empty($row) || count($row) < 2) {
                continue;
            }

            $question = trim($row[0] ?? '');
            $answer = trim($row[1] ?? '');
            $category = trim($row[2] ?? 'Umum') ?: 'Umum';
            $keywords = trim($row[3] ?? '');

            if ($question === '' || $answer === '') {
                $failed++;
                continue;
            }

            Faq::create([
                'question' => $question,
                'answer' => $answer,
                'category' => $category,
                'keywords' => $keywords,
                'is_active' => true,
                'created_by' => Auth::id(),
            ]);

            $imported++;
        }

        $msg = "Berhasil mengimpor {$imported} FAQ.";
        if ($failed > 0) {
            $msg .= " ({$failed} baris dilewati karena data tidak lengkap).";
        }

        return redirect()->route('admin.faq.index')->with('success', $msg);
    }
}

