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
        
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->date('leave_date');
            $table->time('leave_time');             
            $table->string('leave_reason');
            $table->integer('student_id')->unsigned();    
            $table->foreign('student_id')->references('id')->on('Students');
            $table->string('student_signature');
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
        Schema::dropIfExists('leaves');
    }
};
