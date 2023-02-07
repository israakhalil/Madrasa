<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students');
            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');;
            $table->date('absence_date')->nullable();
            $table->string('absence_reason')->nullable();
            $table->string('teacher_signature')->nullable();
            $table->integer('absence_type_id')->unsigned();
            $table->string('attached')->nullable();
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
        Schema::dropIfExists('absences');
    }
};
