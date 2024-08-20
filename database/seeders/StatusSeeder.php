<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = Status::create([
            'status_name' => 'Aktif',
            'color' => '#ff0000',
        ]);

        $status = Status::create([
            'status_name' => 'Tidak Aktif',
            'color' => '#ff0000',
        ]);

        $status = Status::create([
            'status_name' => 'Proses',
            'color' => '#ff0000',
        ]);

        $status = Status::create([
            'status_name' => 'Selesai',
            'color' => '#ff0000',
        ]);
    }
}
