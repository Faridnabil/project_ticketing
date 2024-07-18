<?php

namespace App\Imports;

use App\Models\CityOrRegency;
use App\Models\Province;
use Maatwebsite\Excel\Concerns\ToModel;

class CityOrRegencyImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari province_id berdasarkan kode_provinsi
        $province = Province::where('no_province', $row[0])->first();

        // Jika province tidak ditemukan, Anda bisa menangani sesuai kebutuhan, misalnya return null atau lempar exception
        if (!$province) {
            // Tindakan jika province tidak ditemukan, misalnya skip row ini
            return null;
        }

        return new CityOrRegency([
            'province_id' => $province->id,
            'no_city_or_regency' => $row[1],
            'city_or_regency_name' => $row[2],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
