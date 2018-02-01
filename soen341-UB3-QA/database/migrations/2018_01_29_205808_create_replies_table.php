<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
            $table->integer('question_id')->references('id')->on('questions');
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('likectr');
            $table->integer('dislikectr');
            //status: -1 : rejecting answer, 0: normal answer, 1: accepted answer
            $table->integer('status');
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
        Schema::dropIfExists('replies');
    }
}
