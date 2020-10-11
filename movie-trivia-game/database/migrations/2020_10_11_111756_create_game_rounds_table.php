<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_rounds', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable(false)->index();
            $table->string('guess')->nullable(false);
            $table->integer('score')->nullable(false);
            $table->bigInteger('imdb_data_id')->index();
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('sessions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('game_rounds');
        Schema::enableForeignKeyConstraints();
    }
}
