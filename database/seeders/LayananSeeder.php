<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Category;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['service_name' => 'service1', 'color' => '#ff0000'],
            ['service_name' => 'service2', 'color' => '#ff0000'],
            ['service_name' => 'service3', 'color' => '#ff0000'],
            ['service_name' => 'service4', 'color' => '#ff0000'],
            ['service_name' => 'service5', 'color' => '#ff0000'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
