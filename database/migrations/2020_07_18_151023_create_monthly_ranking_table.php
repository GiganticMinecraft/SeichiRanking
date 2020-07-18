<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyRankingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_ranking_table', function (Blueprint $table) {
            $table->increments('id');
            $table->date('count_date');
            $table->string('name');
            $table->string('uuid');
            $table->bigInteger('break_count')->default(0);
            $table->bigInteger('build_count')->default(0);
            $table->integer('vote_count')->default(0);
            $table->bigInteger('previous_break_count');
            $table->bigInteger('previous_build_count');
            $table->integer('previous_vote_count');
            $table->bigInteger('playtick_count')->default(0);
            $table->bigInteger('previous_playtick_count');
            $table->softDeletes();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_ranking_table');
    }
}
