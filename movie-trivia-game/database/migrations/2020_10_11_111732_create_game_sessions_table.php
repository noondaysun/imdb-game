<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id_initiator')->nullable()->index();
            $table->string('session_id_challenger')->nullable()->index();
            $table->timestamps();

            $table->index(['session_id_initiator', 'session_id_challenger'])->unique();
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
        Schema::dropIfExists('game_sessions');
        Schema::enableForeignKeyConstraints();
    }
}
