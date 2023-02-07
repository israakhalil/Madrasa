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
        Schema::create('violations', function (Blueprint $table) {
            $table->increments('id');
            $table->date('violation_date')->nullable();
            $table->string('action_performed')->nullable();
            $table->integer('violation_procedure_id')->unsigned();
            $table->foreign('violation_procedure_id')->references('id')->on('violation_procedures');
            $table->integer('violation_degree_id')->unsigned();
            $table->foreign('violation_degree_id')->references('id')->on('violation_degrees');
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students');
            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');;
            $table->string('supervisor_signature')->nullable();
            $table->string('student_signature')->nullable();
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
        Schema::dropIfExists('violations');
    }
};
