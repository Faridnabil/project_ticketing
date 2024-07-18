<?php

namespace App\Exports;

use App\Models\CityOrRegency;
use Maatwebsite\Excel\Concerns\FromCollection;

class CityOrRegencyExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CityOrRegency::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Provinsi',
            'Kode Kota/Kabupaten',
            'Nama Kota/Kabupaten',
        ];
    }
}
