<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriviaGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trivia_genres', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('trivia_id');
            $table->foreign('trivia_id')->references('id')->on('trivias')->onDelete('cascade');
            $table->unsignedInteger('genre_id');
            $table->foreign('genre_id')->references('id')->on('create_genres')->onDelete('cascade');
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
        Schema::dropIfExists('trivia_genres');
    }
}
