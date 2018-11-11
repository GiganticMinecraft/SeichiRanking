<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBuildCompetitionTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('build_competition_theme_division', function (Blueprint $table) {
            $table->renameColumn('theme_division_id', 'id');
            $table->renameColumn('build_competition_group', 'build_competition_manage_id');
        });

        Schema::table('build_competition_theme_division', function (Blueprint $table) {
            $table->integer('build_competition_manage_id')->unsigned()->change();
            $table->foreign('build_competition_manage_id')->references('id')->on('build_competition_manage')
                ->name('bc_manage_id_foreign');
        });

        Schema::table('build_competition_apply', function (Blueprint $table) {
            $table->renameColumn('build_competition_apply_id', 'id');
        });

        Schema::table('build_competition_vote', function (Blueprint $table) {
            $table->renameColumn('build_competition_vote_id', 'id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('build_competition_theme_division', function (Blueprint $table) {
            $table->integer('build_competition_manage_id')->change();
            $table->renameColumn('id', 'theme_division_id');
            $table->renameColumn('build_competition_manage_id', 'build_competition_group');
        });

        Schema::table('build_competition_apply', function (Blueprint $table) {
            $table->renameColumn('id', 'build_competition_apply_id');
        });

        Schema::table('build_competition_vote', function (Blueprint $table) {
            $table->renameColumn('id', 'build_competition_vote_id');
        });
    }
}
