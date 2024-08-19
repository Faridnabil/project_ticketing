<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = Service::create([
            'service_name' => 'Wifi Rusak',
            'color' => '#ff0000',
        ]);

        $service = Service::create([
            'service_name' => 'Internet Lemot',
            'color' => '#ff0000',
        ]);

        $service = Service::create([
            'service_name' => 'PC Blue Screen',
            'color' => '#ff0000',
        ]);
    }

}
