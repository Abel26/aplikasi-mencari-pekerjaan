<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = [
            'manage categories',
            'manage company',
            'manage jobs',
            'manage candidates',
            'apply job',
        ];

        foreach ($permission as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        // hak akses employer
        $employerRole = Role::firstOrCreate([
            'name' => 'employer',
        ]);
        $employerPermissions = [
            'manage company',
            'manage jobs',
            'manage candidates',
        ];
        $employerRole->syncPermissions($employerPermissions);

        // hak akses employee
        $employeeRole = Role::firstOrCreate([
            'name' => 'employee',
        ]);
        $employeePermissions = [
            'apply job',
        ];
        $employeeRole->syncPermissions($employeePermissions);

        // hak akses super admin
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin',
        ]);
        // Berikan semua permission kepada super_admin
        // $superAdminRole->syncPermissions(Permission::all());

        // Buat user super admin
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => bcrypt('admin123'),
            'avatar' => 'images/default-avatar.png',
            'occupation' => 'Superadmin',
            'experience' => 10,
        ]);
        // Assign role super_admin ke user
        $user->assignRole($superAdminRole);
    }
}
