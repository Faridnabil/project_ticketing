<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Faker\Factory as FakerFactory;
use Database\Factories\NikProvider;

class UsersSeeder extends Seeder
{

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'View Dashboard Admin']);
        Permission::create(['name' => 'View Dashboard Helpdesk']);
        Permission::create(['name' => 'View Dashboard Koordinator']);
        Permission::create(['name' => 'View Dashboard Staff Subdit']);
        Permission::create(['name' => 'View Dashboard SIAK Dev']);
        Permission::create(['name' => 'View Dashboard Pejabat']);
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
        $helpdeskRole = Role::create(['name' => 'Helpdesk']);
        $koordinatorRole = Role::create(['name' => 'Koordinator']);
        $staffSubditRole = Role::create(['name' => 'Staff Subdit']);
        $siakDevRole = Role::create(['name' => 'SIAK Dev']);
        $pejabatRole = Role::create(['name' => 'Pejabat']);

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
        // $CustomerRole->givePermissionTo('View Dashboard Customer');

        // $CustomerRole->givePermissionTo('View Ticket');
        // $CustomerRole->givePermissionTo('Create Ticket');
        // $CustomerRole->givePermissionTo('Edit Ticket');
        // $CustomerRole->givePermissionTo('Delete Ticket');
        // $CustomerRole->givePermissionTo('Show Ticket');

        //Helpdesk
        $helpdeskRole->givePermissionTo('View Dashboard Helpdesk');
        $helpdeskRole->givePermissionTo('View User Management');
        $helpdeskRole->givePermissionTo('Create User');
        $helpdeskRole->givePermissionTo('Edit User');
        $helpdeskRole->givePermissionTo('Delete User');
        $helpdeskRole->givePermissionTo('Show User');

        $helpdeskRole->givePermissionTo('Create Role');
        $helpdeskRole->givePermissionTo('Edit Role');
        $helpdeskRole->givePermissionTo('Delete Role');
        $helpdeskRole->givePermissionTo('Show Role');

        $helpdeskRole->givePermissionTo('Create Permission');
        $helpdeskRole->givePermissionTo('Edit Permission');
        $helpdeskRole->givePermissionTo('Delete Permission');
        $helpdeskRole->givePermissionTo('Show Permission');

        $helpdeskRole->givePermissionTo('View Category');
        $helpdeskRole->givePermissionTo('Create Category');
        $helpdeskRole->givePermissionTo('Edit Category');
        $helpdeskRole->givePermissionTo('Delete Category');
        $helpdeskRole->givePermissionTo('Show Category');

        $helpdeskRole->givePermissionTo('View Priority');
        $helpdeskRole->givePermissionTo('Create Priority');
        $helpdeskRole->givePermissionTo('Edit Priority');
        $helpdeskRole->givePermissionTo('Delete Priority');
        $helpdeskRole->givePermissionTo('Show Priority');

        $helpdeskRole->givePermissionTo('View Status');
        $helpdeskRole->givePermissionTo('Create Status');
        $helpdeskRole->givePermissionTo('Edit Status');
        $helpdeskRole->givePermissionTo('Delete Status');
        $helpdeskRole->givePermissionTo('Show Status');

        $helpdeskRole->givePermissionTo('View Ticket');
        $helpdeskRole->givePermissionTo('Create Ticket');
        $helpdeskRole->givePermissionTo('Edit Ticket');
        $helpdeskRole->givePermissionTo('Delete Ticket');
        $helpdeskRole->givePermissionTo('Show Ticket');

        $helpdeskRole->givePermissionTo('View Category');
        $helpdeskRole->givePermissionTo('Create Category');
        $helpdeskRole->givePermissionTo('Edit Category');
        $helpdeskRole->givePermissionTo('Delete Category');
        $helpdeskRole->givePermissionTo('Show Category');

        $helpdeskRole->givePermissionTo('View Priority');
        $helpdeskRole->givePermissionTo('Create Priority');
        $helpdeskRole->givePermissionTo('Edit Priority');
        $helpdeskRole->givePermissionTo('Delete Priority');
        $helpdeskRole->givePermissionTo('Show Priority');

        $helpdeskRole->givePermissionTo('View Status');
        $helpdeskRole->givePermissionTo('Create Status');
        $helpdeskRole->givePermissionTo('Edit Status');
        $helpdeskRole->givePermissionTo('Delete Status');
        $helpdeskRole->givePermissionTo('Show Status');

        $helpdeskRole->givePermissionTo('View Province');
        $helpdeskRole->givePermissionTo('Create Province');
        $helpdeskRole->givePermissionTo('Edit Province');
        $helpdeskRole->givePermissionTo('Delete Province');
        $helpdeskRole->givePermissionTo('Show Province');

        $helpdeskRole->givePermissionTo('View City Or Regency');
        $helpdeskRole->givePermissionTo('Create City Or Regency');
        $helpdeskRole->givePermissionTo('Edit City Or Regency');
        $helpdeskRole->givePermissionTo('Delete City Or Regency');
        $helpdeskRole->givePermissionTo('Show City Or Regency');

        $helpdeskRole->givePermissionTo('View Attendance');
        $helpdeskRole->givePermissionTo('Create Attendance');
        $helpdeskRole->givePermissionTo('Edit Attendance');
        $helpdeskRole->givePermissionTo('Delete Attendance');
        $helpdeskRole->givePermissionTo('Show Attendance');

        $helpdeskRole->givePermissionTo('View Ticket');
        $helpdeskRole->givePermissionTo('Create Ticket');
        $helpdeskRole->givePermissionTo('Edit Ticket');
        $helpdeskRole->givePermissionTo('Delete Ticket');
        $helpdeskRole->givePermissionTo('Show Ticket');

        //Koordinator
        $koordinatorRole->givePermissionTo('View Dashboard Koordinator');

        $koordinatorRole->givePermissionTo('View Category');
        $koordinatorRole->givePermissionTo('Create Category');
        $koordinatorRole->givePermissionTo('Edit Category');
        $koordinatorRole->givePermissionTo('Delete Category');
        $koordinatorRole->givePermissionTo('Show Category');

        $koordinatorRole->givePermissionTo('View Priority');
        $koordinatorRole->givePermissionTo('Create Priority');
        $koordinatorRole->givePermissionTo('Edit Priority');
        $koordinatorRole->givePermissionTo('Delete Priority');
        $koordinatorRole->givePermissionTo('Show Priority');

        $koordinatorRole->givePermissionTo('View Status');
        $koordinatorRole->givePermissionTo('Create Status');
        $koordinatorRole->givePermissionTo('Edit Status');
        $koordinatorRole->givePermissionTo('Delete Status');
        $koordinatorRole->givePermissionTo('Show Status');

        $koordinatorRole->givePermissionTo('View Ticket');
        $koordinatorRole->givePermissionTo('Create Ticket');
        $koordinatorRole->givePermissionTo('Edit Ticket');
        $koordinatorRole->givePermissionTo('Delete Ticket');
        $koordinatorRole->givePermissionTo('Show Ticket');

        $faker = FakerFactory::create();
        $faker->addProvider(new NikProvider($faker));

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'Admin@gmail.com',
            'password' => bcrypt('qwerty12'),
            'nik' => $faker->nik,
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Helpdesk 1',
            'email' => 'helpdesk1@gmail.com',
            'password' => bcrypt('qwerty12'),
            'nik' => $faker->nik,
        ]);
        $user->assignRole($helpdeskRole);

        $user = User::factory()->create([
            'name' => 'Helpdesk 2',
            'email' => 'helpdesk2@gmail.com',
            'password' => bcrypt('qwerty12'),
            'nik' => $faker->nik,
        ]);
        $user->assignRole($helpdeskRole);

        $user = User::factory()->create([
            'name' => 'Helpdesk 3',
            'email' => 'helpdesk3@gmail.com',
            'password' => bcrypt('qwerty12'),
            'nik' => $faker->nik,
        ]);
        $user->assignRole($helpdeskRole);

        $user = User::factory()->create([
            'name' => 'Koordinator',
            'email' => 'Koordinator@gmail.com',
            'password' => bcrypt('qwerty12'),
            'nik' => $faker->nik,
        ]);
        $user->assignRole($koordinatorRole);

        $user = User::factory()->create([
            'name' => 'Staff Subdit',
            'email' => 'StaffSubdit@gmail.com',
            'password' => bcrypt('qwerty12'),
            'nik' => $faker->nik,
        ]);
        $user->assignRole($staffSubditRole);

        $user = User::factory()->create([
            'name' => 'SIAK Dev',
            'email' => 'Siakdev@gmail.com',
            'password' => bcrypt('qwerty12'),
            'nik' => $faker->nik,
        ]);
        $user->assignRole($siakDevRole);

        $user = User::factory()->create([
            'name' => 'Pejabat',
            'email' => 'Pejabat@gmail.com',
            'password' => bcrypt('qwerty12'),
            'nik' => $faker->nik,
        ]);
        $user->assignRole($pejabatRole);
    }
}
