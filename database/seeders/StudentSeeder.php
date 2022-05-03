<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //get random name
        $json = file_get_contents(base_path() . "/names.json");
        $array = json_decode($json, true);

        $enrty_year = ['2016', '2017', '2018', '2019', '2020', '2021'];

        foreach (range(1, 50) as $item) {
            $name =  Str::lower($array[rand(0, count($array) - 1)]);

            User::create([
                "name" => $name,
                "email" => $name . rand(1, 100) . '@student.su.edu.kr',
                "password" => bcrypt("password"),
                "entry_year" => $enrty_year[array_rand($enrty_year)],
                "stage" => rand(1, 6),
                "dept_id" => Department::inRandomOrder()->first()->id,
                "is_student" => 1,
            ]);
        }
    }
}
