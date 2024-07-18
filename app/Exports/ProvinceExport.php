<?php

namespace App\Exports;

use App\Models\Province;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProvinceExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Province::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Provinsi',
            'Nama Provinsi',
        ];
    }
}
