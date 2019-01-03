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
        // 24時間以内にログインしたユーザのデータを取得する
        $previous_data = PlayerData::where('lastquit', '>', Carbon::yesterday())->get();
//        logger($previous_data);

        foreach ($previous_data as $player_data) {
            // カウント用テーブルのデータ有無を確認
            $today_count = DailyRankingTable::where('name', $player_data->name)
                ->where('uuid', $player_data->uuid)
                ->where('count_date', Carbon::now()->format('Y-m-d'))->count();
            logger($today_count);

            if (!$today_count) {
                // カウント用テーブルにデータ登録
                $daily_ranking_table = new DailyRankingTable();
                $daily_ranking_table->count_date = Carbon::now();
                $daily_ranking_table->name = $player_data->name;
                $daily_ranking_table->uuid = $player_data->name;
                $daily_ranking_table->previous_break_count = $player_data->totalbreaknum;
                $daily_ranking_table->previous_build_count = $player_data->build_count;
                $daily_ranking_table->previous_vote_count  = $player_data->p_vote;
                $daily_ranking_table->save();
            } else {
                // TODO カウント用テーブルから、更新分の差分データを計算

                // TODO カウント用テーブルのデータ更新
            }
        }

        //
    }
}
