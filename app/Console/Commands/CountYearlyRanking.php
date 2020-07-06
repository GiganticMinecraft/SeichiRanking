<?php

namespace App\Console\Commands;

use App\YearlyRankingTable;
use App\PlayerData;
use Carbon\Carbon;

class CountYearlyRanking extends CountRanking
{
    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        logger('>>>>  イヤリーランキングバッチ：処理開始 >>>>');

        // 24時間以内にログインしたユーザを更新対象にする
        $target_data = PlayerData::where('lastquit', '>', Carbon::yesterday())->get();
        logger('処理対象件数：'.count($target_data));
        $this->countRanking($target_data);

        logger('<<<<  イヤリーランキングバッチ：処理終了 <<<<');
    }

    /**
     * ランキングデータのカウント＋保存
     * @param $target_data
     */
    private function countRanking($target_data)
    {
        foreach ($target_data as $player_data) {
            // カウント用テーブルのデータ有無を確認
            $year_data = YearlyRankingTable::where('uuid', $player_data->uuid)
                ->whereyear('count_date', Carbon::now()->year)->first();

            if (empty($year_data)) {
                // カウント用テーブルに比較用の初期データを登録
                parent::registerInitialData(new YearlyRankingTable(), $player_data);
            } else {
                // 初期データとの差分を記録
                parent::registerDiffData($year_data, $player_data);
            }
        }
    }
}
