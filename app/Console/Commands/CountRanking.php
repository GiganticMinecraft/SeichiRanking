<?php

namespace App\Console\Commands;

use Carbon\Carbon;

abstract class CountRanking
{
    abstract public function handle();

    /**
     * 対象ランキングテーブルに比較用の初期データを登録する
     * @param $ranking_table: 対象ランキングテーブル
     * @param $player_data: 現在のプレイヤデータ
     */
    protected function registerInitialData($ranking_table, $player_data){
        $ranking_table->count_date = Carbon::now();   // datetime
        $ranking_table->name = $player_data->name;    // varchar(30)
        $ranking_table->uuid = $player_data->uuid;    // varchar(128)
        $ranking_table->previous_break_count = $player_data->totalbreaknum;   // bigint(20)
        $ranking_table->previous_build_count = $player_data->build_count;     // int(11)
        $ranking_table->previous_vote_count = $player_data->p_vote;           // int(11)
        $ranking_table->previous_playtick_count = $player_data->playtick;     // int(11)
        $ranking_table->save();
    }
    
    /**
     * 対象ランキングテーブルに初期データと現在のデータの差分を記録
     * @param $ranking_table: 対象ランキングテーブル
     * @param $player_data: 現在のプレイヤデータ
     */
    protected function registerDiffData($ranking_table, $player_data){
        // 整地量
        $diff_break = $player_data->totalbreaknum - $ranking_table->previous_break_count;
        $ranking_table->break_count= $diff_break;

        // 建築量
        $diff_build = $player_data->build_count - $ranking_table->previous_build_count;
        $ranking_table->build_count= $diff_build;

        $diff_tick = $player_data->playtick - $ranking_table->previous_playtick_count;
        $ranking_table->playtick_count = $diff_tick;

        // 投票数
        $ranking_table->vote_count= $player_data->p_vote;

        $ranking_table->save();
    }
}