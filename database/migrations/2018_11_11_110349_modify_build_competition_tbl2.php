<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBuildCompetitionTbl2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('build_competition_apply', function (Blueprint $table) {
            $table->renameColumn('build_competition_group', 'build_competition_manage_id');
            $table->foreign('build_competition_manage_id')->references('id')->on('build_competition_manage')
                ->name('bc_manage_id_foreign');
        });

        Schema::table('build_competition_manage', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('build_competition_apply', function (Blueprint $table) {
            $table->renameColumn('build_competition_manage_id', 'build_competition_group');
        });

        Schema::table('build_competition_manage', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
