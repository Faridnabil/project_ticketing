<?php

namespace App\Imports;

use App\Models\Province;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProvinceImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Province([
            'no_province' => $row['kode_provinsi'],
            'province_name' => $row['nama_provinsi'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 1;
    }
}
