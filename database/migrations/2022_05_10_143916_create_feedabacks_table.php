<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedabacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedabacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('std_id')->comment('student_id')->constrained('users','id')->nullOnDelete();
            $table->foreignId('lec_id')->comment('lecturer_id')->constrained('lecturers','id')->nullOnDelete();
            $table->foreignId('sub_id')->comment('subject_id')->constrained('subjects','id')->nullOnDelete();
            $table->foreignId('dept_id')->comment('department_id')->constrained('deparments','id')->nullOnDelete();
            $table->integer('score')->comment('avarage of marks that teacher get');
            $table->char('result')->nullable();
            $table->boolean('status')->nullable();
            $table->year('feedback_year')->nullable();
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
        Schema::dropIfExists('feedabacks');
    }
}
