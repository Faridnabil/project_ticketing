<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $categories = [
            "Security Technician", "Network Technician", "Cloud Technician"
        ];

        foreach($categories as $category)
        {
            Category::create([
                'name'  => $category,

            ]);
        }
    }
}
