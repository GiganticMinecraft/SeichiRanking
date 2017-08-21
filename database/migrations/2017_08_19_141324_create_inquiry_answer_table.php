<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiryAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_answer', function (Blueprint $table) {
            $table->increments('inquiry_answer_id');
            $table->string('name', 30);
            $table->integer('admin_id');    // 回答を行ったユーザID
            $table->text('answer_text');
            $table->dateTime('answer_date');
            $table->boolean('delete_flg')->default(0);;
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
        Schema::dropIfExists('inquiry_answer');
    }
}
