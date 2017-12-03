<?php

namespace App\Http\Models\Api\PlayerRanking;

class PlaytimeRankingResolver extends RankingResolver
{
    const COMPARE_TARGET = 'playtick';
    const RANKING_TYPE = 'playtime';

    /**
     * プレイ時間(tick)を時間を表す array に変換する
     * @param $playtick int プレイ時間(tick)
     * @return array PlayTimeを表す配列
     */
    private function toPlayTimeObject($playtick)
    {
        $play_seconds = intdiv($playtick, 20);
        $play_minutes = intdiv($play_seconds, 60);
        $play_hours = intdiv($play_minutes, 60);

        return [
            "hours" => $play_hours,
            "minutes" => $play_minutes % 60,
            "seconds" => $play_seconds % 60
        ];
    }

    protected function toPlayerRank($fetched_player_row)
    {
        if ($fetched_player_row == null) {
            return null;
        }

        return [
            "player" => [
                'name' => $fetched_player_row->name,
                'uuid' => $fetched_player_row->uuid,
            ],
            "type" => $this->getRankingType(),
            "rank" => $fetched_player_row->rank,
            "data" => [
                'raw_data' => "$fetched_player_row->data",
                'data' => $this->toPlayTimeObject($fetched_player_row->data)
            ],
            "lastquit" => $fetched_player_row->lastquit
        ];
    }

    function getRankComparator()
    {
        return self::COMPARE_TARGET;
    }

    function getRankingType()
    {
        return self::RANKING_TYPE;
    }
}