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

        Permission::create([
            'name' => 'view todos',
            'guard_name' => 'api'
    ]);
        Permission::create([
            'name' => 'store todo',
            'guard_name' => 'api'
    ]);
        Permission::create([
            'name' => 'show todo',
            'guard_name' => 'api'
    ]);
        Permission::create([
            'name' => 'update todo',
            'guard_name' => 'api'
    ]);
        Permission::create([
            'name' => 'delete todo',
            'guard_name' => 'api'
    ]);
        
    
        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(Permission::all());
    }
}
