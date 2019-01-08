<?php

namespace App\Console\Commands;

use App\DailyRankingTable;
use App\PlayerData;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CountDailyRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranking:count {type=daily}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Web整地ランキングのカウント用バッチ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

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
                $daily_ranking_table->count_date = Carbon::now();
                $daily_ranking_table->name = $player_data->name;
                $daily_ranking_table->uuid = $player_data->uuid;
                $daily_ranking_table->previous_break_count = $player_data->totalbreaknum;
                $daily_ranking_table->previous_build_count = $player_data->build_count;
                $daily_ranking_table->previous_vote_count = $player_data->p_vote;
                $daily_ranking_table->previous_playtick_count = $player_data->playtick;
                $daily_ranking_table->save();
            } else {
                // 整地量
                $diff_break = $player_data->totalbreaknum - $today_data->previous_break_count;
                $today_data->break_count= $diff_break;

                // 建築量
                $diff_build = $player_data->build_count - $today_data->previous_build_count;
                $today_data->build_count= $diff_build;

                // 投票数
                $today_data->vote_count= $player_data->p_vote;

                $today_data->save();
            }
        }
    }
}
