<?php

namespace App\Console\Commands;

use App\DailyRankingTable;
use App\PlayerData;
use Carbon\Carbon;

class CountDailyRanking extends CountRanking
{
    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        logger('>>>>  デイリーランキングバッチ：処理開始 >>>>');

        // 24時間以内にログインしたユーザのデータを取得する
        $target_data = PlayerData::where('lastquit', '>', Carbon::yesterday())->get();
        logger('処理対象件数：'.count($target_data));
        $this->countRanking($target_data);

        logger('<<<<  デイリーランキングバッチ：処理終了 <<<<');
    }

    /**
     * ランキングデータのカウント＋保存
     * @param $target_data
     */
    private function countRanking($target_data)
    {
        foreach ($target_data as $player_data) {
            // カウント用テーブルのデータ有無を確認
            $today_data = DailyRankingTable::where('uuid', $player_data->uuid)
                ->where('count_date', Carbon::now()->format('Y-m-d'))->first();

            if (empty($today_data)) {
                // カウント用テーブルに比較用の初期データを登録
                $daily_ranking_table = new DailyRankingTable();
                parent::savePreviousData($daily_ranking_table, $player_data);
            } else {
                // 整地量
                parent::saveDiffData($today_data, $player_data);
            }
        }
    }
}
