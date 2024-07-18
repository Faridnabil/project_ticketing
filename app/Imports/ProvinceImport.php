<?php

namespace App\Imports;

use App\Models\Province;
use Maatwebsite\Excel\Concerns\ToModel;

class ProvinceImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Province([
            'no_province' => $row[0],
            'province_name' => $row[1],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
