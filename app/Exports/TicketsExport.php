<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $start_date;
    protected $end_date;
    protected $status_id;

    public function __construct($start_date, $end_date, $status_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->status_id = $status_id;
    }

    public function query()
    {
        $query = Ticket::query();

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }

        if ($this->status_id) {
            $query->where('status_id', $this->status_id);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Nomor Tiket',
            'Judul',
            'Pemilik',
            'Tetapkan Ke',
            'Prioritas',
            'Dibuat pada Tanggal',
            'Status',
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->no_ticket,
            $ticket->title,
            $ticket->customers->name,
            $ticket->assignTo ? $ticket->assignTo->name : 'Belum ditetapkan',
            $ticket->priority->name,
            $ticket->created_at->format('d F Y'),
            $ticket->status->status_name,
        ];
    }
}
