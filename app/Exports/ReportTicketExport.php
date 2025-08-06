<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

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
                'No' => $ticket->id,
                'Nomor Tiket' => $ticket->no_ticket,
                'Dibuat Tanggal' => Carbon::parse($ticket->created_at)->locale('id')->translatedFormat('d F Y'),
                'No Provinsi' => $ticket->province->no_province,
                'Nama Provinsi' => $ticket->province->province_name,
                'No Kabupaten' => $ticket->cityOrRegency->no_city_or_regency,
                'Nama Kabupaten' => $ticket->cityOrRegency->city_or_regency_name,
                'Permasalahan' => strip_tags(html_entity_decode($ticket->description)),
                'Solusi' => strip_tags(html_entity_decode($ticket->completion_notes)),
                'Kategori' => $ticket->category->category_name,
                'Disposisi' => $disposisi,
                'Prioritas' => $priority,
                'Status' => $status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Tiket',
            'Dibuat Tanggal',
            'No Provinsi',
            'Nama Provinsi',
            'No Kabupaten',
            'Nama Kabupaten',
            'Permasalahan',
            'Solusi',
            'Kategori',
            'Disposisi',
            'Prioritas',
            'Status',
        ];
    }
}
