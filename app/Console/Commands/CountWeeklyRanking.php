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

        // 24時間以内にログインしたユーザを更新対象にする
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
            $player = WeeklyRankingTable::where('uuid', $player_data->uuid)->first();

            Carbon::setWeekStartsAt(Carbon::SUNDAY);    // 週の始まりの曜日設定
            Carbon::setWeekEndsAt(Carbon::SATURDAY);    // 週の終わりの曜日設定
            // Carbon::now()->startOfWeek()で週の始まりの年月日を取得
            // 期間内のデータが存在するかを確認
            $week_data = WeeklyRankingTable::where('uuid', $player_data->uuid)
                ->wherebetween('count_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->first();

            if (empty($player)) {
                // カウント用テーブルに比較用の初期データを登録
                parent::registerInitialData(new WeeklyRankingTable(), $player_data);
            } else if (empty($week_data)){
                // 比較用の初期データを更新
                parent::registerInitialData($player, $player_data);
            } else {
                // 初期データとの差分を記録
                parent::registerDiffData($week_data, $player_data);
            }
        }
    }
}