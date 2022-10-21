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
        Schema::create('delays', function (Blueprint $table) {
            $table->increments('id');   
            $table->date('delay_date');
            $table->string('delay_reason');
            $table->string('delay_amount');   
            $table->string('student_signature');          
            $table->integer('student_id')->unsigned();    
            $table->foreign('student_id')->references('id')->on('Students');
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
        Schema::dropIfExists('delays');
    }
};
