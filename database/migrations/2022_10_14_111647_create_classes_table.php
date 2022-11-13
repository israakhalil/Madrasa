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
        // if(!Schema::hasTable('Classes')){
            Schema::create('classes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->text('attached_file')->nullable();
                $table->integer('school_id')->unsigned();
                $table->foreign('school_id')->references('id')->on('schools');
                $table->integer('level_id')->unsigned();
                $table->foreign('level_id')->references('id')->on('levels');
//                $table->integer('user_id')->unsigned();
//                $table->foreign('user_id')->references('id')->on('users');
                $table->timestamps();
            });
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
};
