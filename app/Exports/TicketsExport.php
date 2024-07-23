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

    public function __construct($start_date, $end_date, $user_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->user_id = $user_id;
    }

    public function query()
    {
        $query = Ticket::with('status', 'category', 'priority', 'customers', 'assignTo', 'statusChangedByUser')
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
            $ticket->no_ticket,
            $ticket->customers->name,
            $ticket->title,
            $ticket->category->category_name,
            $ticket->priority->priority_name,
            $ticket->description,
            $ticket->solution,
            $ticket->created_at->format('d F Y'),
            $ticket->updated_at->format('d F Y'),
            $ticket->status->status_name,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply styles to the first row (headers)
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FF4CAF50'],
            ],
        ]);

        // Apply border to all cells
        $sheet->getStyle('A1:J' . ($sheet->getHighestRow()))
            ->getBorders()->getAllBorders()->applyFromArray([
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ]);

        // Adjust column widths automatically
        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            // Other styles can be defined here
        ];
    }
}
