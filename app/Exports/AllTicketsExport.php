<?php

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AllTicketsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    protected $request;
    protected $rowNumber = 1;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Ticket::query()->with('status', 'category', 'priority', 'customers', 'assignTo', 'statusChangedByUser');

        if ($this->request->has('category_id') && $this->request->category_id) {
            $query->where('category_id', $this->request->category_id);
        }

        if ($this->request->has('assign_to') && $this->request->assign_to) {
            $query->where('assign_to', $this->request->assign_to);
        }

        if ($this->request->has('priority_id') && $this->request->priority_id) {
            $query->where('priority_id', $this->request->priority_id);
        }

        if ($this->request->has('status_id') && $this->request->status_id) {
            $query->where('status_id', $this->request->status_id);
        }

        if ($this->request->has('start_date') && $this->request->start_date) {
            $query->whereDate('created_at', '>=', $this->request->start_date);
        }

        if ($this->request->has('end_date') && $this->request->end_date) {
            $query->whereDate('created_at', '<=', $this->request->end_date);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Tiket',
            'Kategori',
            'Pemilik',
            'Tetapkan Ke',
            'Prioritas',
            'Dibuat Tanggal',
            'Status',
        ];
    }

    public function map($ticket): array
    {
        return [
            $this->rowNumber++,
            $ticket->no_ticket,
            $ticket->category->category_name,
            $ticket->customers->name,
            $ticket->assignTo->name,
            $ticket->priority->priority_name,
            $ticket->created_at->format('d F Y'),
            $ticket->status->status_name,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Add the title
        $sheet->insertNewRowBefore(1, 1);
        $sheet->setCellValue('A1', 'Data Tiket');
        $sheet->mergeCells('A1:H1');
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

        // Apply styles to the header row
        $sheet->getStyle('A2:H2')->applyFromArray([
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
        $sheet->getStyle('A1:H' . ($sheet->getHighestRow()))
            ->getBorders()->getAllBorders()->applyFromArray([
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ]);

        // Adjust column widths automatically
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            // Other styles can be defined here
        ];
    }
}
