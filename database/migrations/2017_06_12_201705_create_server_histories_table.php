<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('server_id');
            $table->string('name')->nullable();
            $table->string('mapname')->nullable();
            $table->string('gametype')->nullable();
            $table->integer('clients')->nullable();
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
        Schema::dropIfExists('server_histories');
    }
}
