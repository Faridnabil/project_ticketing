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
                'Nomor Tiket' => $ticket->no_ticket,
                'Kategori' => $ticket->category->category_name,
                'Permasalahan' => strip_tags(html_entity_decode($ticket->description)),
                'Solusi' => strip_tags(html_entity_decode($ticket->completion_notes)),
                'Diselesaikan Tanggal' => Carbon::parse($ticket->created_at)->locale('id')->translatedFormat('d F Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Tiket',
            'Kategori',
            'Permasalahan',
            'Solusi',
            'Diselesaikan Tanggal',
        ];
    }
}
