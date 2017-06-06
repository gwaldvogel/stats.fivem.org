<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servers', function (Blueprint $table){
            $table->string('name')->after('ipaddress');
            $table->boolean('enhancedHostSupport')->after('name');
            $table->string('gamename')->after('enhancedHostSupport');
            $table->string('gametype')->after('gamename');
            $table->integer('latestPlayerCount')->after('gametype');
            $table->integer('slots')->after('latestPlayerCount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
