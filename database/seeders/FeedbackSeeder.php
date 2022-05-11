<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Feedback;
use App\Models\Lecturer;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // only software student
        // each student feedback for 4 years
        // no repeat student
        $years = [
            '2019 - 2020',
            '2019 - 2020',
            '2020 - 2021',
            '2021 - 2022',
        ];


        $students = User::query()
            ->inRandomOrder()
            ->where("is_student", 1)
            ->take(100)->get();


        // get software lecturer 
        $softwareDeptId = Department::where('name', 'like', '%software%')->first()->id;
        $softwareLecturers = Lecturer::with([
            'subjects' => function ($qeury) {
                $qeury->select('name')->first();
            }
        ])->take(10)->get();


        //each student submit four year for diffrent lecture and subject for that lecutre 
        foreach ($students as $student) { // 100
            foreach ($softwareLecturers as $lecturer) { // 10
                foreach ($years as $year) { // 4

                    DB::table('feedbacks')->insert([
                        "std_id" => $student->id,
                        "dept_id" => 10,
                        "lec_id" => $lecturer->id,
                        "sub_id" => $lecturer->subject[0]->name ?? rand(1, 100),
                        "score" => rand(70, 100),
                        "feedback_year" => $year,
                        "created_at" => Carbon::today(),
                        "updated_at" => Carbon::today(),
                    ]);
                }
            }
        }
    }
}
