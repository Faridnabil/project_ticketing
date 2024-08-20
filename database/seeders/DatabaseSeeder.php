<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(PrioritySeeder::class);
        $this->call(LayananSeeder::class); 
        // $this->call(CategorySeeder::class);
    }
}
