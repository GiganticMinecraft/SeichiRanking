<?php

namespace App\Http\Models\Api\PlayerRanking;

class BuildRankingResolver extends RankingResolver
{
    const COMPARE_TARGET = 'build_count';
    const RANKING_TYPE = 'build';

    function getRankComparator()
    {
        return self::COMPARE_TARGET;
    }

    function getRankingType()
    {
        return self::RANKING_TYPE;
    }
}