<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $managerRole = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $viewerRole = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);

        // Create permissions
        $permissions = [
            // Document permissions
            'document.view',
            'document.create',
            'document.edit',
            'document.delete',
            'document.download',
            
            // Category permissions
            'category.view',
            'category.create',
            'category.edit',
            'category.delete',
            
            // Work Unit permissions
            'workunit.view',
            'workunit.create',
            'workunit.edit',
            'workunit.delete',
            
            // User permissions
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            
            // Activity Log permissions
            'activitylog.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign permissions to roles
        $adminRole->syncPermissions(Permission::all());

        $managerRole->syncPermissions([
            'document.view',
            'document.create',
            'document.edit',
            'document.delete',
            'document.download',
            'category.view',
            'workunit.view',
            'user.view',
            'user.create',
            'user.edit',
            'activitylog.view',
        ]);

        $userRole->syncPermissions([
            'document.view',
            'document.create',
            'document.edit',
            'document.download',
            'activitylog.view',
        ]);

        $viewerRole->syncPermissions([
            'document.view',
            'document.download',
        ]);
    }
}
