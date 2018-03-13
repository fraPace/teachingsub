<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

//        // create permissions
//        Permission::create(['name' => 'edit articles']);
//        Permission::create(['name' => 'delete articles']);
//        Permission::create(['name' => 'publish articles']);
//        Permission::create(['name' => 'unpublish articles']);

        // create roles and assign existing permissions
//        $role = Role::create(['name' => 'writer']);
//        $role->givePermissionTo('edit articles');

//        $role = Role::create(['name' => 'admin']);
//        $role->givePermissionTo(['publish articles', 'unpublish articles']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'professor']);
        Role::create(['name' => 'ta']);
        Role::create(['name' => 'student']);
    }
}