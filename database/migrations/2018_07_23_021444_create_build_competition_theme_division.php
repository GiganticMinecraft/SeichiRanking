<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildCompetitionThemeDivision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('build_competition_theme_division', function (Blueprint $table) {
            $table->increments('id')->comment('建築コンペテーマID');
            $table->integer('build_competition_manage_id')->comment('建築コンペ開催回ID');
            $table->foreign('build_competition_manage_id')->references('id')->on('build_competition_manage')->name('bc_theme_division_bc_manage_id_foreign');
            $table->string('theme_division_name')->comment('テーマ種別');
            $table->string('glyphicon')->nullable()->comment('グラフアイコン');
            $table->timestamps();
        });

        \DB::statement("ALTER TABLE build_competition_theme_division COMMENT '建築コンペテーマ種別テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('build_competition_theme_division');
    }
}
