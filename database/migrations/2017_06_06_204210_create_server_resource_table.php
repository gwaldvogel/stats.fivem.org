<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_resource', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_id')
                ->unsigned();
            $table->integer('server_resource_id')
                ->unsigned();
            $table->timestamps();
            $table->foreign('server_id')
                ->references('id')
                ->on('servers')
                ->onDelete('cascade');
            $table->foreign('server_resource_id')
                ->references('id')
                ->on('server_resources')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_server_resource');
    }
}
