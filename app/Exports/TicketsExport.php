<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TicketsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $start_date;
    protected $end_date;
    protected $user_id;
    protected $rowNumber = 1; // Menambahkan properti untuk melacak nomor urut

    public function __construct($start_date, $end_date, $user_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->user_id = $user_id;
    }

    public function query()
    {
        $query = Ticket::with('status', 'category', 'priority', 'user_s', 'assignTo', 'statusChangedByUser')
            ->whereHas('assignTo', function ($q) {
                $q->where('id', $this->user_id);
            })
            ->where('status_id', 4);

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',               // Tambahkan kolom No
            'Nomor Tiket',
            'Pemilik',
            'Judul',
            'Kategori',
            'Prioritas',
            'Deskripsi',
            'Solusi',
            'Dibuat pada Tanggal',
            'Selesai pada Tanggal',
            'Status',
        ];
    }

    public function map($ticket): array
    {
        return [
            $this->rowNumber++,                 // Tambahkan nomor urut
            $ticket->no_ticket,
            $ticket->user_s->name,
            $ticket->title,
            $ticket->category->category_name,
            $ticket->priority->priority_name,
            strip_tags($ticket->description),   // Hilangkan tag HTML
            strip_tags($ticket->solution),      // Hilangkan tag HTML
            $ticket->created_at->format('d F Y'),
            $ticket->updated_at->format('d F Y'),
            $ticket->status->status_name,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Menambahkan judul
        $sheet->insertNewRowBefore(1, 1);
        $sheet->setCellValue('A1', 'Data Tiket Selesai');
        $sheet->mergeCells('A1:K1');  // Sesuaikan kolom dengan menambahkan satu kolom untuk No
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FF4CAF50'],
            ],
        ]);

        // Menerapkan gaya pada baris header
        $sheet->getStyle('A2:K2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FF4CAF50'],
            ],
        ]);

        // Menerapkan border pada semua sel
        $sheet->getStyle('A1:K' . ($sheet->getHighestRow()))
            ->getBorders()->getAllBorders()->applyFromArray([
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ]);

        // Menyesuaikan lebar kolom secara otomatis
        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            // Gaya lainnya dapat didefinisikan di sini
        ];
    }
}
