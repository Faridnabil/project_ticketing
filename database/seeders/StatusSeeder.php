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
            'status_name' => 'Open',
            'color' => '#ff0000',
        ]);

        $status = Status::create([
            'status_name' => 'Pending',
            'color' => '#ff0000',
        ]);

        $status = Status::create([
            'status_name' => 'Progress',
            'color' => '#ff0000',
        ]);

        $status = Status::create([
            'status_name' => 'Closed',
            'color' => '#ff0000',
        ]);
    }
}
