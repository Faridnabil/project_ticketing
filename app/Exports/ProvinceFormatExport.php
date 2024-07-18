<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class ProvinceFormatExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            [
                'KODE PROVINSI',
                'NAMA PROVINSI'
            ]
        ];
    }
}
