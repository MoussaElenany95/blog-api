<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create user admin
        $role = Role::create(["name"=>"Admin"]);
        //get all permissions 
        $permissions = Permission::all()->pluck('id');
        //sync all permissions to admin
        $role->permissions()->sync($permissions);
    }   
}
