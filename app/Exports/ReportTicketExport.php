<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportTicketExport implements FromCollection, WithHeadings
{
    private $tickets;

    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    public function collection()
    {
        return $this->tickets->map(function ($ticket) {
            $disposisi = '-';
            if ($ticket->level1 != null) {
                $disposisi = $ticket->helpdesk->name;
            } elseif ($ticket->level2 != null) {
                $disposisi = $ticket->koordinator->name;
            } elseif ($ticket->level3 != null) {
                $disposisi = $ticket->staffSubdit->name;
            } elseif ($ticket->level4 != null) {
                $disposisi = $ticket->siakDev->name;
            } elseif ($ticket->level5 != null) {
                $disposisi = $ticket->pejabat->name;
            }

            $priority = '-';
            if ($ticket->priority_id == '4') {
                $priority = 'Critical';
            } elseif ($ticket->priority_id == '3') {
                $priority = 'High';
            } elseif ($ticket->priority_id == '2') {
                $priority = 'Medium';
            } elseif ($ticket->priority_id == '1') {
                $priority = 'Low';
            }

            $status = '-';
            if ($ticket->status_id == '1') {
                $status = 'Tertunda';
            } elseif ($ticket->status_id == '2') {
                $status = 'Diterima';
            } elseif ($ticket->status_id == '3') {
                $status = 'Proses';
            } elseif ($ticket->status_id == '4') {
                $status = 'Selesai';
            } elseif ($ticket->status_id == '5') {
                $status = 'Buka Kembali';
            }

            return [
                'Nomor Tiket' => $ticket->no_ticket,
                'Kategori' => $ticket->category->category_name,
                'Disposisi' => $disposisi,
                'Prioritas' => $priority,
                'Dibuat Tanggal' => date('d F Y', strtotime($ticket->created_at)),
                'Status' => $status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor Tiket',
            'Kategori',
            'Disposisi',
            'Prioritas',
            'Dibuat Tanggal',
            'Status',
        ];
    }
}
