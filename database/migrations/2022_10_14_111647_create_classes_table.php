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
            Schema::create('Classes', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name');
                $table->text('attached_file')->nullable();
                $table->integer('school_id')->unsigned();
                $table->foreign('school_id')->references('id')->on('Schools');
                $table->integer('level_id')->unsigned();
                $table->foreign('level_id')->references('id')->on('Levels');
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('Users');
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
