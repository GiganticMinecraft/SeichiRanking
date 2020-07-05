<?php


namespace App\Console\Commands;


use App\MonthlyRankingTable;
use App\PlayerData;
use Carbon\Carbon;

use Illuminate\Console\Command;

class CountMonthlyRanking extends Command
{
    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        logger('>>>>  マンスリーランキングバッチ：処理開始 >>>>');

        // 24時間以内にログインしたユーザのデータを取得する
        $target_data = PlayerData::where('lastquit', '>', Carbon::yesterday())->get();
        logger('処理対象件数：' . count($target_data));
        $this->countRanking($target_data);

        logger('<<<<  マンスリーランキングバッチ：処理終了 <<<<');
    }

    /**
     * ランキングデータのカウント＋保存
     * @param $target_data
     */
    private function countRanking($target_data)
    {
        foreach ($target_data as $player_data) {
            // カウント用テーブルのデータ有無を確認
            $today_data = MonthlyRankingTable::where('uuid', $player_data->uuid)
                ->whereMonth('count_date', Carbon::now()->month)->first();

            if (empty($today_data)) {
                // カウント用テーブルに比較用の初期データを登録
                $monthly_ranking_table = new MonthlyRankingTable();
                $monthly_ranking_table->count_date = Carbon::now();   // datetime
                $monthly_ranking_table->name = $player_data->name;    // varchar(30)
                $monthly_ranking_table->uuid = $player_data->uuid;    // varchar(128)
                $monthly_ranking_table->previous_break_count = $player_data->totalbreaknum;   // bigint(20)
                $monthly_ranking_table->previous_build_count = $player_data->build_count;     // int(11)
                $monthly_ranking_table->previous_vote_count = $player_data->p_vote;           // int(11)
                $monthly_ranking_table->previous_playtick_count = $player_data->playtick;     // int(11)
                $monthly_ranking_table->save();
            } else {
                // 整地量
                $diff_break = $player_data->totalbreaknum - $today_data->previous_break_count;
                $today_data->break_count= $diff_break;

                // 建築量
                $diff_build = $player_data->build_count - $today_data->previous_build_count;
                $today_data->build_count= $diff_build;

                $diff_tick = $player_data->playtick - $today_data->previous_playtick_count;
                $today_data->playtick_count = $diff_tick;

                // 投票数
                $today_data->vote_count= $player_data->p_vote;

                $today_data->save();
            }
        }
    }
}