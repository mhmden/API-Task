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
     *
     * @return void
     */
    public function run()
    {
        // * Clear cached roles and permission RECOMENDED
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create a list of permission names

        $userPermissions = [
            'index todos', 
            'store todo',
            'show todo',
            'update todo',
            'delete todo',
            'index tags',
            'store tag',
            'show tag',
            'update tag',
            'destroy tag',
        ];
        $adminPermissions = [
            'index statuses',
            'store status',
            'show status',
            'update status',
            'destroy status',
            'index trash',
            'show trashed',
            'update trashed', // * Restore
            'delete trashed', // * ForceDelete
            'index banned',
            'store banned', // * Issue Ban
            'destroy banned' // * unBan
        ];

        $permissions = collect(array_merge($userPermissions, $adminPermissions))->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray()); // Insert accepts an array.

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($userPermissions);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($adminPermissions);
    }
}
