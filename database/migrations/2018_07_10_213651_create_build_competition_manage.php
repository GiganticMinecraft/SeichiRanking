<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildCompetitionManage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('build_competition_manage', function (Blueprint $table) {
            $table->increments('id')->comment('建築コンペ開催回ID');
            $table->string('build_competition_manage_name')->comment('開催名');
            $table->timestamps();
        });

        \DB::statement("ALTER TABLE build_competition_manage COMMENT '建築コンペ開催管理'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('build_competition_manage');
    }
}
