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
            $table->foreignId('std_id')->nullable()->comment("student_id")->constrained('users','id')->nullOnDelete()->onUpdate('cascade');
            $table->foreignId('lec_id')->nullable()->comment('lecturer_id')->constrained('lecturers','id')->nullOnDelete()->onUpdate('cascade');
            $table->foreignId('sub_id')->nullable()->comment('subject_id')->constrained('subjects','id')->nullOnDelete()->onUpdate('cascade');
            $table->foreignId('dept_id')->nullable()->comment('department_id')->constrained('departments','id')->nullOnDelete()->onUpdate('cascade');
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
