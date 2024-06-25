<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priority = Priority::create([
            'priority_name' => 'Low / Level 1',
            'color' => '#ff0000',
        ]);

        $priority = Priority::create([
            'priority_name' => 'Low / Level 2',
            'color' => '#ff0000',
        ]);
    }
}
