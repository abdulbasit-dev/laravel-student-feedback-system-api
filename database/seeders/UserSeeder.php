<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "admin",
            "user_name" => 'admin',
            "email" => "admin@su.edu.krd",
            "password" => bcrypt("password",)
        ])->assignRole('admin');
    }
}
