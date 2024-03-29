<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip');
            $table->integer('port');
            $table->string('icon')->nullable();
            $table->string('country_code')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('gametype');
            $table->string('name');
            $table->string('mapname');
            $table->integer('max_clients');
            $table->integer('clients');
            $table->timestamps();
            $table->unique(['ip', 'port']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
}
