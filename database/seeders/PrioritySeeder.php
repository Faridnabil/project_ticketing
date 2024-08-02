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
            'priority_name' => 'Low',
            'color' => '#ff0000',
        ]);

        $priority = Priority::create([
            'priority_name' => 'High',
            'color' => '#ff0000',
        ]);

        $priority = Priority::create([
            'priority_name' => 'Medium',
            'color' => '#ff0000',
        ]);
        $priority = Priority::create([
            'priority_name' => 'Critical',
            'color' => '#ff0000',
        ]);
    }
}
