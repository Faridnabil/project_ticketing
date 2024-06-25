<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UsersSeeder extends Seeder
{

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'View User Management']);
        Permission::create(['name' => 'Create User']);
        Permission::create(['name' => 'Edit User']);
        Permission::create(['name' => 'Delete User']);
        Permission::create(['name' => 'Show User']);

        Permission::create(['name' => 'Create Role']);
        Permission::create(['name' => 'Edit Role']);
        Permission::create(['name' => 'Delete Role']);
        Permission::create(['name' => 'Show Role']);

        Permission::create(['name' => 'Create Permission']);
        Permission::create(['name' => 'Edit Permission']);
        Permission::create(['name' => 'Delete Permission']);
        Permission::create(['name' => 'Show Permission']);

        Permission::create(['name' => 'View Category']);
        Permission::create(['name' => 'Create Category']);
        Permission::create(['name' => 'Edit Category']);
        Permission::create(['name' => 'Delete Category']);
        Permission::create(['name' => 'Show Category']);

        Permission::create(['name' => 'View Priority']);
        Permission::create(['name' => 'Create Priority']);
        Permission::create(['name' => 'Edit Priority']);
        Permission::create(['name' => 'Delete Priority']);
        Permission::create(['name' => 'Show Priority']);

        Permission::create(['name' => 'View Status']);
        Permission::create(['name' => 'Create Status']);
        Permission::create(['name' => 'Edit Status']);
        Permission::create(['name' => 'Delete Status']);
        Permission::create(['name' => 'Show Status']);

        Permission::create(['name' => 'View Ticket']);
        Permission::create(['name' => 'Create Ticket']);
        Permission::create(['name' => 'Edit Ticket']);
        Permission::create(['name' => 'Delete Ticket']);
        Permission::create(['name' => 'Show Ticket']);

        //create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $CustomerRole = Role::create(['name' => 'Customer']);
        $DepartementRole = Role::create(['name' => 'Departement']);

        //Admin
        $adminRole->givePermissionTo('View User Management');
        $adminRole->givePermissionTo('Create User');
        $adminRole->givePermissionTo('Edit User');
        $adminRole->givePermissionTo('Delete User');
        $adminRole->givePermissionTo('Show User');

        $adminRole->givePermissionTo('Create Role');
        $adminRole->givePermissionTo('Edit Role');
        $adminRole->givePermissionTo('Delete Role');
        $adminRole->givePermissionTo('Show Role');

        $adminRole->givePermissionTo('Create Permission');
        $adminRole->givePermissionTo('Edit Permission');
        $adminRole->givePermissionTo('Delete Permission');
        $adminRole->givePermissionTo('Show Permission');

        $adminRole->givePermissionTo('View Category');
        $adminRole->givePermissionTo('Create Category');
        $adminRole->givePermissionTo('Edit Category');
        $adminRole->givePermissionTo('Delete Category');
        $adminRole->givePermissionTo('Show Category');

        $adminRole->givePermissionTo('View Priority');
        $adminRole->givePermissionTo('Create Priority');
        $adminRole->givePermissionTo('Edit Priority');
        $adminRole->givePermissionTo('Delete Priority');
        $adminRole->givePermissionTo('Show Priority');

        $adminRole->givePermissionTo('View Status');
        $adminRole->givePermissionTo('Create Status');
        $adminRole->givePermissionTo('Edit Status');
        $adminRole->givePermissionTo('Delete Status');
        $adminRole->givePermissionTo('Show Status');

        $adminRole->givePermissionTo('View Ticket');
        $adminRole->givePermissionTo('Create Ticket');
        $adminRole->givePermissionTo('Edit Ticket');
        $adminRole->givePermissionTo('Delete Ticket');
        $adminRole->givePermissionTo('Show Ticket');

        //Customer
        $CustomerRole->givePermissionTo('View Ticket');
        $CustomerRole->givePermissionTo('Create Ticket');
        $CustomerRole->givePermissionTo('Edit Ticket');
        $CustomerRole->givePermissionTo('Delete Ticket');
        $CustomerRole->givePermissionTo('Show Ticket');

        //Department
        $DepartementRole->givePermissionTo('View Category');
        $DepartementRole->givePermissionTo('Create Category');
        $DepartementRole->givePermissionTo('Edit Category');
        $DepartementRole->givePermissionTo('Delete Category');
        $DepartementRole->givePermissionTo('Show Category');

        $DepartementRole->givePermissionTo('View Priority');
        $DepartementRole->givePermissionTo('Create Priority');
        $DepartementRole->givePermissionTo('Edit Priority');
        $DepartementRole->givePermissionTo('Delete Priority');
        $DepartementRole->givePermissionTo('Show Priority');

        $DepartementRole->givePermissionTo('View Status');
        $DepartementRole->givePermissionTo('Create Status');
        $DepartementRole->givePermissionTo('Edit Status');
        $DepartementRole->givePermissionTo('Delete Status');
        $DepartementRole->givePermissionTo('Show Status');

        $DepartementRole->givePermissionTo('View Ticket');
        $DepartementRole->givePermissionTo('Create Ticket');
        $DepartementRole->givePermissionTo('Edit Ticket');
        $DepartementRole->givePermissionTo('Delete Ticket');
        $DepartementRole->givePermissionTo('Show Ticket');

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'Admin@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Customer',
            'email' => 'Customer@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($CustomerRole);

        $user = User::factory()->create([
            'name' => 'Departement',
            'email' => 'Departement@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($DepartementRole);
    }
}
