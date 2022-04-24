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

        // $userPermissions = ['view todos', 'store todo', 'show todo', 'update todo', 'delete todo'];

        // $permissions = collect($userPermissions)->map(function ($permission) {
        //     return ['name' => $permission];
        // });

        // Permission::insert($permissions->toArray());

        Permission::create([
            'name' => 'view todos',
        ]);
        Permission::create([
            'name' => 'store todo',
        ]);
        Permission::create([
            'name' => 'show todo',
        ]);
        Permission::create([
            'name' => 'update todo',
        ]);
        Permission::create([
            'name' => 'delete todo',
        ]);
        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(Permission::all());
    }
}
