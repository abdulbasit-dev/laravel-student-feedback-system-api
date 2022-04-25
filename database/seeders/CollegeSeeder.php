<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            "College of Science",
            "College of Engineering ",
            "College of Agriculture Engineering Sciences",
            "College of Education ",
            "College of Arts ",
            "College of Languages ",
            "College of Administration and Economics",
            "College of Law",
            "College of Basic Education ",
            "College of Physical Education & Sport Sciences",
            "College of Fine Arts ",
            "College of Islamic Sciences ",
            "College of Education-Makhmour ",
            "College of Education-Shaqlawa ",
            "College of Political Sciences",
        ];


        foreach ($arr as $name) {
            College::firstOrCreate([
                "name" => $name
            ]);
        }
    }
}
