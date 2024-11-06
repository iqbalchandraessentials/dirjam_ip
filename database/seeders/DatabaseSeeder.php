<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Buat Permissions
        $permissions = [
            'view reports',
            'edit reports',
            'delete reports',
            'assign tasks',
            'approve requests'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat Roles dan assign Permissions ke role-role tertentu
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $staffRole = Role::firstOrCreate(['name' => 'Staff']);

        // Assign permissions ke role Admin
        $adminRole->givePermissionTo(Permission::all());

        // Assign permissions ke role Manager
        $managerRole->givePermissionTo(['view reports', 'assign tasks']);

        // Assign permissions ke role Staff
        $staffRole->givePermissionTo(['view reports']);
    }
}
