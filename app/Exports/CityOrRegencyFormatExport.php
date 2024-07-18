<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class CityOrRegencyFormatExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            [
                'KODE PROVINSI',
                'KODE KOTA/KABUPATEN',
                'NAMA KOTA/KABUPATEN'
            ]
        ];
    }
}
