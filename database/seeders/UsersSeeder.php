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
        Permission::create(['name' => 'View Dashboard Customer']);
        Permission::create(['name' => 'View Dashboard Department']);

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

        Permission::create(['name' => 'View Province']);
        Permission::create(['name' => 'Create Province']);
        Permission::create(['name' => 'Edit Province']);
        Permission::create(['name' => 'Delete Province']);
        Permission::create(['name' => 'Show Province']);

        Permission::create(['name' => 'View City Or Regency']);
        Permission::create(['name' => 'Create City Or Regency']);
        Permission::create(['name' => 'Edit City Or Regency']);
        Permission::create(['name' => 'Delete City Or Regency']);
        Permission::create(['name' => 'Show City Or Regency']);

        Permission::create(['name' => 'View Attendance']);
        Permission::create(['name' => 'Create Attendance']);
        Permission::create(['name' => 'Edit Attendance']);
        Permission::create(['name' => 'Delete Attendance']);
        Permission::create(['name' => 'Show Attendance']);

        Permission::create(['name' => 'View Ticket']);
        Permission::create(['name' => 'Create Ticket']);
        Permission::create(['name' => 'Edit Ticket']);
        Permission::create(['name' => 'Delete Ticket']);
        Permission::create(['name' => 'Show Ticket']);

        //create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $CustomerRole = Role::create(['name' => 'Customer']);
        $DepartmentRole = Role::create(['name' => 'Department']);
        $KoordinatorRole = Role::create(['name' => 'Koordinator']);
        $StaffSubditRole = Role::create(['name' => 'Staff Subdit']);
        $SiakDevRole = Role::create(['name' => 'SIAK Dev']);
        $PejabatRole = Role::create(['name' => 'Pejabat']);

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

        $adminRole->givePermissionTo('View Province');
        $adminRole->givePermissionTo('Create Province');
        $adminRole->givePermissionTo('Edit Province');
        $adminRole->givePermissionTo('Delete Province');
        $adminRole->givePermissionTo('Show Province');

        $adminRole->givePermissionTo('View City Or Regency');
        $adminRole->givePermissionTo('Create City Or Regency');
        $adminRole->givePermissionTo('Edit City Or Regency');
        $adminRole->givePermissionTo('Delete City Or Regency');
        $adminRole->givePermissionTo('Show City Or Regency');

        $adminRole->givePermissionTo('View Attendance');
        $adminRole->givePermissionTo('Create Attendance');
        $adminRole->givePermissionTo('Edit Attendance');
        $adminRole->givePermissionTo('Delete Attendance');
        $adminRole->givePermissionTo('Show Attendance');

        $adminRole->givePermissionTo('View Ticket');
        $adminRole->givePermissionTo('Create Ticket');
        $adminRole->givePermissionTo('Edit Ticket');
        $adminRole->givePermissionTo('Delete Ticket');
        $adminRole->givePermissionTo('Show Ticket');

        //Customer
        $CustomerRole->givePermissionTo('View Dashboard Customer');

        $CustomerRole->givePermissionTo('View Ticket');
        $CustomerRole->givePermissionTo('Create Ticket');
        $CustomerRole->givePermissionTo('Edit Ticket');
        $CustomerRole->givePermissionTo('Delete Ticket');
        $CustomerRole->givePermissionTo('Show Ticket');

        //Department
        $DepartmentRole->givePermissionTo('View Dashboard Department');

        $DepartmentRole->givePermissionTo('View Category');
        $DepartmentRole->givePermissionTo('Create Category');
        $DepartmentRole->givePermissionTo('Edit Category');
        $DepartmentRole->givePermissionTo('Delete Category');
        $DepartmentRole->givePermissionTo('Show Category');

        $DepartmentRole->givePermissionTo('View Priority');
        $DepartmentRole->givePermissionTo('Create Priority');
        $DepartmentRole->givePermissionTo('Edit Priority');
        $DepartmentRole->givePermissionTo('Delete Priority');
        $DepartmentRole->givePermissionTo('Show Priority');

        $DepartmentRole->givePermissionTo('View Status');
        $DepartmentRole->givePermissionTo('Create Status');
        $DepartmentRole->givePermissionTo('Edit Status');
        $DepartmentRole->givePermissionTo('Delete Status');
        $DepartmentRole->givePermissionTo('Show Status');

        $DepartmentRole->givePermissionTo('View Ticket');
        $DepartmentRole->givePermissionTo('Create Ticket');
        $DepartmentRole->givePermissionTo('Edit Ticket');
        $DepartmentRole->givePermissionTo('Delete Ticket');
        $DepartmentRole->givePermissionTo('Show Ticket');

        //Department
        $DepartmentRole->givePermissionTo('View Dashboard Department');

        $DepartmentRole->givePermissionTo('View Category');
        $DepartmentRole->givePermissionTo('Create Category');
        $DepartmentRole->givePermissionTo('Edit Category');
        $DepartmentRole->givePermissionTo('Delete Category');
        $DepartmentRole->givePermissionTo('Show Category');

        $DepartmentRole->givePermissionTo('View Priority');
        $DepartmentRole->givePermissionTo('Create Priority');
        $DepartmentRole->givePermissionTo('Edit Priority');
        $DepartmentRole->givePermissionTo('Delete Priority');
        $DepartmentRole->givePermissionTo('Show Priority');

        $DepartmentRole->givePermissionTo('View Status');
        $DepartmentRole->givePermissionTo('Create Status');
        $DepartmentRole->givePermissionTo('Edit Status');
        $DepartmentRole->givePermissionTo('Delete Status');
        $DepartmentRole->givePermissionTo('Show Status');

        $DepartmentRole->givePermissionTo('View Ticket');
        $DepartmentRole->givePermissionTo('Create Ticket');
        $DepartmentRole->givePermissionTo('Edit Ticket');
        $DepartmentRole->givePermissionTo('Delete Ticket');
        $DepartmentRole->givePermissionTo('Show Ticket');

        $user = User::factory()->create([
            'name' => 'Admin Shift 1',
            'email' => 'Admin1@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Admin Shift 2',
            'email' => 'Admin2@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Admin Shift 3',
            'email' => 'Admin3@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Customer1',
            'email' => 'Customer1@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($CustomerRole);

        $user = User::factory()->create([
            'name' => 'Customer2',
            'email' => 'Customer2@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($CustomerRole);

        $user = User::factory()->create([
            'name' => 'Department1',
            'email' => 'Department1@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($DepartmentRole);

        $user = User::factory()->create([
            'name' => 'Department2',
            'email' => 'Department2@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($DepartmentRole);

        $user = User::factory()->create([
            'name' => 'Koordinator',
            'email' => 'Koordinator@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($KoordinatorRole);

        $user = User::factory()->create([
            'name' => 'Staff Subdit',
            'email' => 'StaffSubdit@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($StaffSubditRole);

        $user = User::factory()->create([
            'name' => 'SIAK Dev',
            'email' => 'Siakdev@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($SiakDevRole);

        $user = User::factory()->create([
            'name' => 'Pejabat',
            'email' => 'Pejabat@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($PejabatRole);
    }
}
