<?php

namespace App\Exports;

use App\Models\Province;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProvinceExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Province::select('no_province', 'province_name')->get();
    }

    public function headings(): array
    {
        return [
            'KODE PROVINSI',
            'NAMA PROVINSI',
        ];
    }
}
