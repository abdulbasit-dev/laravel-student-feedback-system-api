<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->nullable()->constrained('colleges', 'id');
            $table->foreignId('dept_id')->nullable()->constrained('departments', 'id');
            $table->foreignId('title_id')->nullable()->constrained('academic_titles', 'id');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lecturers');
    }
}

// CREATE VIEW `lecturers` AS
// SELECT `college_id` , `department_id` AS `dept_id`, CONCAT( `fname` ,`mname` ,`lname`) AS `name`, `title_id`
// FROM `profiles`
