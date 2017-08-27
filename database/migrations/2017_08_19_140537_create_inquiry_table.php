<?php
/**
 * プレイヤーからのお問い合わせデータを管理する
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry', function (Blueprint $table) {
            $table->increments('inquiry_id');
            $table->string('name', 30);
            $table->text('inquiry_text');
            $table->dateTime('inquiry_date');
            $table->boolean('solved_flg')->default(0);
            $table->boolean('delete_flg')->default(0);
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
        Schema::dropIfExists('inquiry');
    }
}
