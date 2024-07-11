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
            'category_name' => 'A',
            'color' => '#ff0000',
        ]);

        $category = Category::create([
            'category_name' => 'B',
            'color' => '#ff0000',
        ]);

        $category = Category::create([
            'category_name' => 'C',
            'color' => '#ff0000',
        ]);
        $category = Category::create([
            'category_name' => 'D',
            'color' => '#ff0000',
        ]);
    }
}
