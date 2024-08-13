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

        Permission::create(['name' => 'View Dashboard Admin']);
        Permission::create(['name' => 'View Dashboard User']);
        Permission::create(['name' => 'View Dashboard SysAdmin']);
        Permission::create(['name' => 'View Dashboard DBA']);

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
        $UserRole = Role::create(['name' => 'User']);
        $SysAdminRole = Role::create(['name' => 'SysAdmin']);
        $DBARole = Role::create(['name' => 'DBA']);

        //Admin
        $adminRole->givePermissionTo('View Dashboard Admin');

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

        //User
        $UserRole->givePermissionTo('View Dashboard User');

        $UserRole->givePermissionTo('View Ticket');
        $UserRole->givePermissionTo('Create Ticket');
        $UserRole->givePermissionTo('Edit Ticket');
        $UserRole->givePermissionTo('Delete Ticket');
        $UserRole->givePermissionTo('Show Ticket');

        //SysAdmin
        $SysAdminRole->givePermissionTo('View Dashboard SysAdmin');

        $SysAdminRole->givePermissionTo('View Category');;
        $SysAdminRole->givePermissionTo('Edit Category');
        $SysAdminRole->givePermissionTo('Show Category');

        $SysAdminRole->givePermissionTo('View Priority');
        $SysAdminRole->givePermissionTo('Edit Priority');
        $SysAdminRole->givePermissionTo('Show Priority');

        $SysAdminRole->givePermissionTo('View Status');
        $SysAdminRole->givePermissionTo('Edit Status');
        $SysAdminRole->givePermissionTo('Show Status');

        $SysAdminRole->givePermissionTo('View Ticket');
        $SysAdminRole->givePermissionTo('Edit Ticket');
        $SysAdminRole->givePermissionTo('Show Ticket');

        //DBA
        $DBARole->givePermissionTo('View Dashboard DBA');

        $DBARole->givePermissionTo('View Category');;
        $DBARole->givePermissionTo('Edit Category');
        $DBARole->givePermissionTo('Show Category');

        $DBARole->givePermissionTo('View Priority');
        $DBARole->givePermissionTo('Edit Priority');
        $DBARole->givePermissionTo('Show Priority');

        $DBARole->givePermissionTo('View Status');
        $DBARole->givePermissionTo('Edit Status');
        $DBARole->givePermissionTo('Show Status');

        $DBARole->givePermissionTo('View Ticket');
        $DBARole->givePermissionTo('Edit Ticket');
        $DBARole->givePermissionTo('Show Ticket');

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'Admin@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'User1',
            'email' => 'User1@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($UserRole);

        $user = User::factory()->create([
            'name' => 'User2',
            'email' => 'User2@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($UserRole);

        $user = User::factory()->create([
            'name' => 'SysAdmin',
            'email' => 'sysadmin@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($SysAdminRole);

        $user = User::factory()->create([
            'name' => 'DBA',
            'email' => 'dba@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($DBARole);
    }
}
