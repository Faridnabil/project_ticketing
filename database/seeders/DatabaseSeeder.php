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
        $this->call(StatusSeeder::class);
        $this->call(PrioritySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(WilayahSeeder::class);
        $this->call(SipdWilayahSeeder::class);
        $this->call(UsersSeeder::class);
    }
}
