<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('std_id')->comment("student_id")->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lec_id')->comment('lecturer_id')->constrained('lecturers','id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sub_id')->comment('subject_id')->constrained('subjects','id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('dept_id')->comment('department_id')->constrained('departments','id')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('score')->comment('avarage of marks that teacher get');
            $table->char('result')->nullable();
            $table->boolean('status')->nullable();
            $table->string('feedback_year')->nullable();
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
        Schema::dropIfExists('feedbacks');
    }
}
