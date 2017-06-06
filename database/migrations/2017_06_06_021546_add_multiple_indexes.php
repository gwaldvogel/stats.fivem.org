<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultipleIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('country_stats_entries', function (Blueprint $table) {
            $table->index('country_stats_id');
        });

        Schema::table('player_crawls', function (Blueprint $table) {
            $table->index('unique_player_id');
            $table->index('server_crawl_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country_stats_entries', function (Blueprint $table) {
            $table->dropIndex('country_stats_id');
        });

        Schema::table('player_crawls', function (Blueprint $table) {
            $table->dropIndex('unique_player_id');
            $table->dropIndex('server_crawl_id');
        });
    }
}
