<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildCompetitionVote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('build_competition_vote', function (Blueprint $table) {
            $table->increments('id')->comment('建築コンペ投票ID');
            $table->integer('build_competition_vote_apply_id')->unsigned()->comment('建築コンペ投票応募ID');
            $table->foreign('build_competition_vote_apply_id')->references('id')->on('build_competition_apply');
            $table->integer('theme_division_id')->unsigned()->comment('テーマ種別');
            $table->foreign('theme_division_id')->references('id')->on('build_competition_theme_division');
            $table->string('uuid')->comment('uuid');
            $table->string('mcid')->comment('mcid');
            $table->timestamps();
        });

        \DB::statement("ALTER TABLE build_competition_vote COMMENT '建築コンペ投票テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('build_competition_vote');
    }
}
