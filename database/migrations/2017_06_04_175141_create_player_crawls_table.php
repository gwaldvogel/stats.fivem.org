<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerCrawlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_crawls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_crawl_id');
            $table->string('endpoint');
            $table->integer('fivemId');
            $table->string('identifier');
            $table->string('name');
            $table->integer('ping');
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
        Schema::dropIfExists('player_crawls');
    }
}
