<?php

namespace App\Http\Models\Api\PlayerRanking;

class PlaytimeRankingResolver extends RankingResolver
{
    const COMPARE_TARGET = 'playtick';
    const RANKING_TYPE = 'playtime';

    protected function toPlayerDataObject($playtick)
    {
        $play_seconds = intdiv($playtick, 20);
        $play_minutes = intdiv($play_seconds, 60);
        $play_hours = intdiv($play_minutes, 60);

        return [
            'raw_data' => "$playtick",
            'data' => [
                "hours" => $play_hours,
                "minutes" => $play_minutes % 60,
                "seconds" => $play_seconds % 60
            ]
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