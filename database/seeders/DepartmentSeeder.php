<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $since = [
            "Department of Biology",
            "Department of Geology",
            "Department of Chemistry",
            "Department of Computer Science",
            "Department of Environmental Science",
            "Department of Mathematics",
            "Department of Physics",
        ];
        foreach ($since as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 1
            ]);
        }

        $eng = [
            "Department of Architecture Engineering",
            "Department of Civil Engineering",
            "Department of Software and Informatics Engineering",
            "Department of Electrical Engineering",
            "Department of Geomatics (Surveying) Engineering",
            "Department of Mechanical Engineering",
            "Department of Water Resources Engineering",
            "Department of Chemical and Petrochemical Engineering",
            "Department of Aviation Engineering ",
        ];
        foreach ($eng as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 2
            ]);
        }


        $agr = [
            "Department of Animal Resources",
            "Department of Soil and water",
            "Department of Food technology",
            "Department of Forestry",
            "Department of Plant Protection",
            "Department of Horticulture",
            "Department of Field crops",
            "Department of Fish Resources and Aquatic Animals",
        ];

        foreach ($agr as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 3
            ]);
        }


        $edu = [
            "Department of Biology",
            "Department of Chemistry",
            "Department of Physics",
            "Department of Mathematics",
            "Department of English",
            "Department of Arabic",
            "Department of Kurdish",
            "Department of Psychology and Educational Sciences",
            "Department of Special Education",
            "Department of Syriac",

        ];
        foreach ($edu as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 4
            ]);
        }

        $art = [
            "Department of Archaeology",
            "Department of Geography",
            "Department of History",
            "Department of Media",
            "Department of Philosophy",
            "Department of Psychology",
            "Department of Social Work",
            "Department of Sociology",
        ];
        foreach ($art as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 5
            ]);
        }


        $lang = [
            "Department of English",
            "Department of German",
            "Department of French",
            "Department of Kurdish",
            "Department of Arabic",
            "Department of Turkish",
            "Department of Persian",
            "Department of Chinese",
        ];
        foreach ($lang as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 6
            ]);
        }

        $ecom = [
            "Department of Accounting",
            "Department of Administration",
            "Department of Economics",
            "Department of Finance and Banking",
            "Department of Statistics",
            "Department of Tourism Organizations Administration",
        ];
        foreach ($ecom as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 7
            ]);
        }

        $law = [
            "Department of Law",
        ];
        foreach ($law as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 8
            ]);
        }

        $base_edu = [
            "Department of General Science",
            "Department of Mathematics",
            "Department of English Language",
            "Department of Kurdish Language",
            "Department of Social Sciences",
            "Department of Kindergarten",
            "Department of Arabic",

        ];
        foreach ($base_edu as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 9
            ]);
        }

        $sport = [
            "Department of Physical Education & Sport Sciences"
        ];
        foreach ($sport as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 10
            ]);
        }

        $fine_art = [
            "Department of Music Arts",
            "Department of Cinema and Theater Arts",
            "Department of Plastic Arts",
        ];
        foreach ($fine_art as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 11
            ]);
        }

        $islamic = [
            "Department of Religious Education",
            "Department of Islamic studies",
            "Department of Principle of religion",
            "Department of Sharia",
        ];
        foreach ($islamic as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 12
            ]);
        }


        $makhmor_edu = [
            "Department of Arabic",
            "Department of Kurdish",
        ];
        foreach ($makhmor_edu as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 13
            ]);
        }

        $shaqlawa_edu = [
            "Department of Biology",
            "Department of Physics",
            "Department of Arabic",
            "Department of Kurdish",
            "Department of Physical Education",
            "Department of English",
        ];
        foreach ($shaqlawa_edu as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 14
            ]);
        }

        $poli_scinec = [
            "Department of Political Systems and Public Policy",
            "Department of International Relations & Diplomacy",
        ];
        foreach ($poli_scinec as $name) {
            Department::firstOrCreate([
                "name" => $name,
                "college_id" => 15
            ]);
        }
    }
}
