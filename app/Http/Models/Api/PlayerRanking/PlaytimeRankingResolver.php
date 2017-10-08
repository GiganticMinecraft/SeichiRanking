<?php

namespace App\Http\Models\Api\PlayerRanking;

class PlaytimeRankingResolver extends RankingResolver
{
    const COMPARE_TARGET = 'playtick';
    const RANKING_TYPE = 'playtime';

    function getRankComparator()
    {
        return self::COMPARE_TARGET;
    }

    function getRankingType()
    {
        return self::RANKING_TYPE;
    }
}