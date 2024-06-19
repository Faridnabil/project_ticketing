<?php

namespace App\Exports;

use App\Helpdesk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HelpdesksExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        return Helpdesk::all();
    }
    public function map($datass): array
    {
        return [
            //data yang dari kolom tabel database yang akan diambil
            $datass->id,
            $datass->ticket_id,
            $datass->subject,
            $datass->email_address,
            $datass->message,
            $datass->priority->escalation_time . " jam" ,
            $datass->priority->name,
            $datass->user->name,
            $datass->status->name,
            $datass->created_at,


        ];
    }
    public function headings(): array
    { {
            return [
                //pastikan urut dan jumlahnya sesuai dengan yang ada di mapping-data atau table di database
                'No',
                'Ticket ID',
                'Subject',
                'Email Address',
                'Message',
                'Eskalasi',
                'Priority',
                'User',
                'Status',
                'Created Date',
                // 'Email Verification',
            ];
        }
    }
}
