<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamPlayerTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_player', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('team_id')->unsigned()->index();
            $table->integer('user_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('CASCADE');
            $table->foreign('team_id')->references('id')->on('team')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_player');
    }
}
