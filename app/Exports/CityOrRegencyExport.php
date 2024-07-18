<?php

namespace App\Exports;

use App\Models\CityOrRegency;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CityOrRegencyExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return CityOrRegency::join('provinces', 'city_or_regencies.province_id', '=', 'provinces.id')
            ->select('provinces.no_province as kode_provinsi', 'city_or_regencies.no_city_or_regency as kode_kota_kabupaten', 'city_or_regencies.city_or_regency_name as nama_kota_kabupaten')
            ->get();
    }

    public function headings(): array
    {
        return [
            'KODE PROVINSI',
            'KODE KOTA/KABUPATEN',
            'NAMA KOTA/KABUPATEN',
        ];
    }
}
