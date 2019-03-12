<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlaytickCountDailyRankingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_ranking_table', function (Blueprint $table) {
            $table->bigInteger('playtick_count')->default(0)->after('build_count');
            $table->bigInteger('previous_playtick_count')->after('previous_build_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_ranking_table', function (Blueprint $table) {
            $table->dropColumn('playtick_count');
            $table->dropColumn('previous_playtick_count');
        });
    }
}
