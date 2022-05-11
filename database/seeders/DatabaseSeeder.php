<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AcademicTitleSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(CollegeSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(LecturerSeeder::class);
        $this->call(FeedbackSeeder::class);

    }
}
