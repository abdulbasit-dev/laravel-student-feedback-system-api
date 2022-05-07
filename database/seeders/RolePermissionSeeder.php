<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions  = [
            "college_add",
            "college_edit",
            "college_import",
            "college_delete",
            "college_view",

            "department_add",
            "department_edit",
            "department_import",
            "department_delete",
            "department_view",

            "feeback_add",
            "feeback_edit",
            "feeback_import",
            "feeback_delete",
            "feeback_view",

            "lecture_add",
            "lecture_edit",
            "lecture_import",
            "lecture_delete",
            "lecture_view",

            "subject_add",
            "subject_edit",
            "subject_import",
            "subject_delete",
            "subject_view",

            "student_add",
            "student_edit",
            "student_import",
            "student_delete",
            "student_view",

            "user_add",
            "user_edit",
            "user_import",
            "user_delete",
            "user_view",
        ];

        //create permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        $roles = ['admin', 'student', 'college-admin', 'depratment-admin'];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
            ]);
        }
    }
}
