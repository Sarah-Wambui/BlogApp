<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin permissions 
        $adminRole = Role::where('name', 'Admin')->first();
        Permission::create(['name'=>'view-user', 'role_id'=> $adminRole->id]);
        Permission::create(['name'=>'view-users', 'role_id'=> $adminRole->id]);
        Permission::create(['name'=>'delete-user', 'role_id'=> $adminRole->id]);
        Permission::create(['name'=>'suspend-user', 'role_id'=> $adminRole->id]);
        Permission::create(['name'=>'view-post', 'role_id'=> $adminRole->id]);
        Permission::create(['name'=>'view-posts', 'role_id'=> $adminRole->id]);
        Permission::create(['name'=>'create-post', 'role_id'=> $adminRole->id]);
        Permission::create(['name'=>'edit-post', 'role_id'=> $adminRole->id]);
        Permission::create(['name'=>'delete-post', 'role_id'=> $adminRole->id]);

        $userRole = Role::where('name', 'User')->first();
        Permission::create(['name'=>'view-post', 'role_id'=> $userRole->id]);
        Permission::create(['name'=>'view-posts', 'role_id'=> $userRole->id]);
        Permission::create(['name'=>'create-post', 'role_id'=> $userRole->id]);
        Permission::create(['name'=>'edit-post', 'role_id'=> $userRole->id]);
        Permission::create(['name'=>'delete-post', 'role_id'=> $userRole->id]);      
    }
}
