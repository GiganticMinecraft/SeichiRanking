<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildCompetitionApply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('build_competition_apply', function (Blueprint $table) {
            $table->increments('id')->comment('建築コンペ応募ID');
            $table->integer('build_competition_group')->unsigned()->comment('建築コンペ区分');
            $table->string('title')->comment('作品名');
            $table->string('apply_comment')->comment('応募者コメント');
            $table->string('mcid')->comment('応募者MCID');
            $table->string('uuid')->comment('応募者UUID');
            $table->string('contact_means')->comment('連絡手段');
            $table->string('contact_id')->comment('コンタクトID');
            $table->integer('theme_division_id')->unsigned()->comment('テーマ種別');
            $table->foreign('theme_division_id')->references('id')->on('build_competition_theme_division');
            $table->string('img_path')->nullable()->comment('画像パス');
            $table->string('partition_operator')->nullable()->comment('区画作業者');
            $table->string('partition_no')->nullable()->comment('区画No');
            $table->string('remarks')->nullable()->comment('備考');
            $table->timestamps();
        });

        \DB::statement("ALTER TABLE build_competition_apply COMMENT '建築コンペ応募テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('build_competition_apply');
    }
}
