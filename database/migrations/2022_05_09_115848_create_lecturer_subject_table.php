<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturer_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecturer_id')->constrained('lecturers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lecturer_subject');
    }
}
