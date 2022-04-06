<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            ["permission"=>"create-user"],
            ["permission"=>"show-user"],
            ["permission"=>"update-user"],
            ["permission"=>"delete-user"],

            ["permission"=>"create-article"],
            ["permission"=>"update-article"],
            ["permission"=>"show-article"],
            ["permission"=>"delete-article"],

            ["permission"=>"create-tag"],
            ["permission"=>"update-tag"],
            ["permission"=>"delete-tag"],
            ["permission"=>"show-tag"],

            ["permission"=>"assign-role"],
            ["permission"=>"create-role"],
            ["permission"=>"update-role"],
            ["permission"=>"delete-role"],
            ["permission"=>"show-role"],

            ["permission"=>"create-permission"],
            ["permission"=>"update-permission"],
            ["permission"=>"show-permission"],
            ["permission"=>"delete-permission"],
        ]);
    }
}
