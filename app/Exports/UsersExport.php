<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    
    public function collection()
    {
        return User::all();
    }
    public function map($datass): array
    {
        return [
            //data yang dari kolom tabel database yang akan diambil
            $datass->id,
            $datass->name,
            $datass->email,
            // $datass->email_verified_at,
            

        ];
    }
    public function headings(): array
    { {
            return [
                //pastikan urut dan jumlahnya sesuai dengan yang ada di mapping-data atau table di database
                'No',
                'Name',
                'Email',
                // 'Email Verification',
            ];
        }
    }
}
