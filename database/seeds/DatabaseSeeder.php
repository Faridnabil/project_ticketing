<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            CategoriesTableSeeder::class,
            // StatusesTableSeeder::class,
            // PrioritiesTableSeeder::class,
        ]);

        // Seeder untuk tabel priorities
        DB::table('priorities')->insert([
            ['name' => 'High', 'level' => 'Level 1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medium', 'level' => 'Level 1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Critical', 'level' => 'Level 1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Low', 'level' => 'Level 2', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seeder untuk tabel statuses
        DB::table('statuses')->insert([
            ['name' => 'Open', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Closed', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
