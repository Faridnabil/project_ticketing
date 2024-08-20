<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    //     $category = Category::create([
    //         'category_name' => 'Wifi Rusak',
    //         'color' => '#ff0000',
    //     ]);

    //     $category = Category::create([
    //         'category_name' => 'Internet Lemot',
    //         'color' => '#ff0000',
    //     ]);

    //     $category = Category::create([
    //         'category_name' => 'PC Blue Screen',
    //         'color' => '#ff0000',
    //     ]);
    // }
    $services = Service::all();
    if ($services->isEmpty()) {
        $this->command->error('No services found. Please run the ServiceSeeder first.');
        return;
    }
    $categories = [
        ['category_name' => 'category1'],
        ['category_name' => 'category2'],
        ['category_name' => 'category3'],
        ['category_name' => 'category4'],
        ['category_name' => 'category5'],
    ];

    // Assign setiap kategori ke layanan yang berbeda
    foreach ($categories as $index => $category) {
        $service = $services->get($index % $services->count());
        Category::create([
            'layanan_id' => $service->id,
            'category_name' => $category['category_name'],
        ]);
    }
}
}
