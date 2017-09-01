<?php

namespace App\Http\Controllers\Api\PlayerRanking;


class BreakRankingResolver extends RankingResolver
{
    const COMPARE_TARGET = 'totalbreaknum';
    const RANKING_TYPE = 'break';

    function getRankComparator()
    {
        return self::COMPARE_TARGET;
    }

    function getRankingType()
    {
        return self::RANKING_TYPE;
    }
}