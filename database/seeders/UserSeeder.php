<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $passworsd = bcrypt("admin123");
        User::insert([
                    "name"=>"admin",
                    "email"=>"admin@blog.com",
                    "password"=>$passworsd,
                    "role_id" => '1'
                ]);
    }
}
