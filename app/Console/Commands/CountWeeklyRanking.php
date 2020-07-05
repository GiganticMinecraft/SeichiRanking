<?php

namespace App\Console\Commands;

use App\WeeklyRankingTable;
use App\PlayerData;
use Carbon\Carbon;

class CountWeeklyRanking extends CountRanking
{
    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        logger('>>>>  ウィークリーランキングバッチ：処理開始 >>>>');

        // 24時間以内にログインしたユーザのデータを取得する
        $target_data = PlayerData::where('lastquit', '>', Carbon::yesterday())->get();
        logger('処理対象件数：' . count($target_data));
        $this->countRanking($target_data);

        logger('<<<<  ウィークリーランキングバッチ：処理終了 <<<<');
    }

    /**
     * ランキングデータのカウント＋保存
     * @param $target_data
     */
    private function countRanking($target_data)
    {
        foreach ($target_data as $player_data) {
            // カウント用テーブルのデータ有無を確認
            Carbon::setWeekStartsAt(Carbon::SUNDAY);
            Carbon::setWeekEndsAt(Carbon::SATURDAY);

            $week_data = WeeklyRankingTable::where('uuid', $player_data->uuid)
                ->wherebetween('count_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->first();

            if (empty($week_data)) {
                // カウント用テーブルに比較用の初期データを登録
                $weekly_ranking_table = new WeeklyRankingTable();
                parent::savePreviousData($weekly_ranking_table, $player_data);
            } else {
                parent::saveDiffData($week_data, $player_data);
            }
        }
    }
}