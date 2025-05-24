<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view dashboard',
            'view admin dashboard',
            'view alumni dashboard',
            'view student dashboard',
            'manage users',
            'approve users',
            'edit profile',
            'view pending approvals',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view dashboard',
            'view admin dashboard',
            'manage users',
            'approve users',
            'view pending approvals',
        ]);

        $alumniRole = Role::create(['name' => 'alumni']);
        $alumniRole->givePermissionTo([
            'view dashboard',
            'view alumni dashboard',
            'edit profile',
        ]);

        $studentRole = Role::create(['name' => 'student']);
        $studentRole->givePermissionTo([
            'view dashboard',
            'view student dashboard',
            'edit profile',
        ]);
    }
}
