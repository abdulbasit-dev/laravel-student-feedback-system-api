<?php

namespace Database\Seeders;

use App\Models\AcademicTitle;
use Illuminate\Database\Seeder;

class AcademicTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            "Assistant lecturer",
            "Lecturer",
            "Assistant professor",
            "Professor",
            "Senior Lecturer",
        ];

        foreach ($titles as  $title) {
            AcademicTitle::create([
                "title" => $title
            ]);
        }
    }
}
