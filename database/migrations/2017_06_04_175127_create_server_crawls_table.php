<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerCrawlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_crawls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_id');
            $table->integer('clients');
            $table->boolean('enhancedHostSupport');
            $table->string('gamename');
            $table->string('gametype');
            $table->string('hostname');
            $table->integer('iconVersion')->default(0);
            $table->string('lastSeen');
            $table->string('mapname');
            $table->integer('protocol');
            $table->text('resources');
            $table->string('server');
            $table->integer('svMaxclients');
            $table->integer('sv_maxclients');
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
        Schema::dropIfExists('server_crawls');
    }
}
