<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::create([
            'category_name' => 'Wifi Rusak',
            'color' => '#ff0000',
        ]);

        $category = Category::create([
            'category_name' => 'Internet Lemot',
            'color' => '#ff0000',
        ]);

        $category = Category::create([
            'category_name' => 'PC Blue Screen',
            'color' => '#ff0000',
        ]);
    }
}
