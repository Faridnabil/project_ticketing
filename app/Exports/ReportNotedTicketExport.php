<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class ReportNotedTicketExport implements FromCollection, WithHeadings
{
    private $tickets;

    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    public function collection()
    {
        return $this->tickets->map(function ($ticket, $index) {
            return [
                'No' => $index + 1,
                'Kategori' => $ticket->category->category_name,
                'Catatan' => strip_tags(html_entity_decode($ticket->completion_notes)),
                'Diselesaikan Tanggal' => Carbon::parse($ticket->created_at)->locale('id')->translatedFormat('d F Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kategori',
            'Catatan',
            'Diselesaikan Tanggal',
        ];
    }
}
