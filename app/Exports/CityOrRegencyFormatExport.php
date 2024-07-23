<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class CityOrRegencyFormatExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            [
                'KODE PROVINSI',
                'KODE KOTA KABUPATEN',
                'NAMA KOTA KABUPATEN'
            ]
        ];
    }
}
