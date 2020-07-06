<?php

namespace App\Console\Commands;

use App\MonthlyRankingTable;
use App\PlayerData;
use Carbon\Carbon;

class CountMonthlyRanking extends CountRanking
{
    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        logger('>>>>  マンスリーランキングバッチ：処理開始 >>>>');

        // 24時間以内にログインしたユーザを更新対象にする
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
            $month_data = MonthlyRankingTable::where('uuid', $player_data->uuid)
                ->whereYear('count_date', Carbon::now()->year)
                ->whereMonth('count_date', Carbon::now()->month)->first();

            if (empty($month_data)) {
                // カウント用テーブルに比較用の初期データを登録
                parent::registerInitialData(new MonthlyRankingTable(), $player_data);
            } else {
                // 初期データとの差分を記録
                parent::registerDiffData($month_data, $player_data);
            }
        }
    }
}