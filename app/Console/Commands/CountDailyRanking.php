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
                // カウント用テーブルにデータ登録
                $daily_ranking_table = new DailyRankingTable();
                $daily_ranking_table->count_date = Carbon::now();
                $daily_ranking_table->name = $player_data->name;
                $daily_ranking_table->uuid = $player_data->uuid;
                $daily_ranking_table->previous_break_count = $player_data->totalbreaknum;
                $daily_ranking_table->previous_build_count = $player_data->build_count;
                $daily_ranking_table->previous_vote_count = $player_data->p_vote;
                $daily_ranking_table->save();
            } else {
                // カウント用テーブルから、更新分の差分データを計算

                // 整地量
                if ($today_data->break_count === 0) {
                    // 初回
                    $diff_break = $player_data->totalbreaknum - $today_data->previous_break_count;
                } else {
                    $diff_break = $player_data->totalbreaknum - $today_data->break_count;
                }

                // 建築量
                if ($today_data->build_count === 0) {
                    // 初回
                    $diff_build = $player_data->build_count - $today_data->previous_build_count;
                } else {
                    $diff_build = $player_data->build_count - $today_data->build_count;
                }

                // 投票数
                if ($today_data->vote_count === 0) {
                    // 初回
                    $diff_vote = $player_data->p_vote - $today_data->previous_vote_count;
                } else {
                    $diff_vote = $player_data->p_vote - $today_data->vote_count;
                }

                if ($diff_break > 0 | $diff_build > 0 | $diff_vote > 0) {
                    logger('update');

                    // カウント用テーブルのデータ更新
                    $today_data->break_count+= $diff_break;
                    $today_data->build_count+= $diff_build;
                    $today_data->vote_count+= $diff_vote;
                    $today_data->save();
                }
            }
        }
    }
}
