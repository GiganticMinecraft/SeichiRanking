<?php

namespace Tests\Unit;

use App\Console\Commands\CountRankingCommand;
use App\DailyRankingTable;
use App\PlayerData;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DailyRankingTest extends TestCase
{

    /**
     * テスト
     *
     * @return void
     */
    public function testDailyRanking()
    {

        // テスト用データの作成
        $player_data = PlayerData::factory()->create();
        logger($player_data);

        // バッチ実行①
        $batch = new CountRankingCommand();
        $batch->handle();

        // 24時間以内にログインしていないため、ヒットしないこと
        $this->assertDatabaseMissing('daily_ranking_table',
            [
                'name' => 'test_user',
                'uuid' => '75f6e1bc-1a06-4470-a67b-265999999999',
            ]
        );

        // 最終ログイン時間を更新
        \DB::table('playerdata')
            ->where('name', $player_data->name)
            ->where('uuid', $player_data->uuid)
            ->update([
                'lastquit' => \Carbon\Carbon::now()->subMinute(5),   // 5分前
            ]);

        // バッチ実行②
        $batch->handle();

        // 初回実行時のデータチェック
        $this->assertDatabaseHas(
            'daily_ranking_table',
            [
                'name' => 'test_user',
                'uuid' => '75f6e1bc-1a06-4470-a67b-265999999999',
                'break_count' => 0,
                'build_count' => 0,
                'vote_count'  => 0,
                'previous_break_count' => 50,
                'previous_build_count' => 50,
                'previous_vote_count'  => 1,
            ]
        );

        // テスト用プレイヤーデータの更新
        \DB::table('playerdata')
            ->where('name', $player_data->name)
            ->where('uuid', $player_data->uuid)
            ->update([
                'totalbreaknum' => 60,
                'build_count' => 60,
                'p_vote' => 2,
            ]);

        // バッチ実行③
        $batch->handle();

        // データチェック
        $this->assertDatabaseHas(
            'daily_ranking_table',
            [
                'name' => 'test_user',
                'uuid' => '75f6e1bc-1a06-4470-a67b-265999999999',
                'break_count' => 10,
                'build_count' => 10,
                'vote_count'  => 1,
                'previous_break_count' => 50,
                'previous_build_count' => 50,
                'previous_vote_count'  => 1,
            ]
        );

        // テスト用データの削除
        \DB::table('playerdata')
            ->where('name', $player_data->name)
            ->where('uuid', $player_data->uuid)
            ->delete();

        \DB::table('daily_ranking_table')
            ->where('name', $player_data->name)
            ->where('uuid', $player_data->uuid)
            ->delete();
    }
}
