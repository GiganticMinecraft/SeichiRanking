<?php

namespace App\Console\Commands;

use Carbon\Carbon;

abstract class CountRanking
{
    abstract public function handle();

    protected function savePreviousData($table, $player_data){
        $table->count_date = Carbon::now();   // datetime
        $table->name = $player_data->name;    // varchar(30)
        $table->uuid = $player_data->uuid;    // varchar(128)
        $table->previous_break_count = $player_data->totalbreaknum;   // bigint(20)
        $table->previous_build_count = $player_data->build_count;     // int(11)
        $table->previous_vote_count = $player_data->p_vote;           // int(11)
        $table->previous_playtick_count = $player_data->playtick;     // int(11)
        $table->save();
    }

    protected function saveDiffData($ranking_data, $player_data){
        $diff_break = $player_data->totalbreaknum - $ranking_data->previous_break_count;
        $ranking_data->break_count= $diff_break;

        // 建築量
        $diff_build = $player_data->build_count - $ranking_data->previous_build_count;
        $ranking_data->build_count= $diff_build;

        $diff_tick = $player_data->playtick - $ranking_data->previous_playtick_count;
        $ranking_data->playtick_count = $diff_tick;

        // 投票数
        $ranking_data->vote_count= $player_data->p_vote;

        $ranking_data->save();
    }
}