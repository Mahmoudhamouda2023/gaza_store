<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = 'admin';

        $permissions = [
            'view dashboard',

            'view products',
            'create products',
            'edit products',
            'delete products',

            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            'view orders',
            'edit orders',
            'delete orders',

            'view payments',
            'view customers',

            'view managers',
            'create managers',
            'edit managers',
            'delete managers',

            'view employees',
            'create employees',
            'edit employees',
            'delete employees',

            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => $guard,
            ]);
        }

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => $guard,
        ]);

        $managerRole = Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => $guard,
        ]);

        $employeeRole = Role::firstOrCreate([
            'name' => 'employee',
            'guard_name' => $guard,
        ]);

        $adminRole->syncPermissions(Permission::where('guard_name', $guard)->get());

        $managerRole->syncPermissions([
            'view dashboard',
            'view products',
            'view categories',
            'view orders',
            'edit orders',
            'view payments',
            'view customers',
        ]);

        $employeeRole->syncPermissions([
            'view dashboard',
            'view products',
            'view categories',
            'view orders',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
