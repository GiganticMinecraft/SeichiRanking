<?php

namespace App\Console\Commands;

use App\WeeklyRankingTable;
use App\PlayerData;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CountWeeklyRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranking:count {type=weekly}';

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
        logger('>>>>  ウィークリーランキングバッチ：処理開始 >>>>');

        // 168時間以内にログインしたユーザのデータを取得する
        $target_data = PlayerData::where('lastquit', '>', Carbon::subDay(7))->get();
        logger('処理対象件数：'.count($target_data));
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
            $today_data = WeeklyRankingTable::where('uuid', $player_data->uuid)
                ->where('count_date', Carbon::now()->format('Y-m-d'))->first();

            if (empty($today_data)) {
                // カウント用テーブルに比較用の初期データを登録
                $weekly_ranking_table = new WeeklyRankingTable();
                $weekly_ranking_table->count_date = Carbon::now();
                $weekly_ranking_table->name = $player_data->name;
                $weekly_ranking_table->uuid = $player_data->uuid;
                $weekly_ranking_table->previous_break_count = $player_data->totalbreaknum;
                $weekly_ranking_table->previous_build_count = $player_data->build_count;
                $weekly_ranking_table->previous_vote_count = $player_data->p_vote;
                $weekly_ranking_table->previous_playtick_count = $player_data->playtick;
                $weekly_ranking_table->save();
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
