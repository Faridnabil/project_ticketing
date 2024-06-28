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
            'status_name' => 'Tertunda',
            'color' => '#ff0000',
        ]);

        $status = Status::create([
            'status_name' => 'Buka',
            'color' => '#ff0000',
        ]);

        $status = Status::create([
            'status_name' => 'Berlangsung',
            'color' => '#ff0000',
        ]);

        $status = Status::create([
            'status_name' => 'Tutup',
            'color' => '#ff0000',
        ]);
    }
}
