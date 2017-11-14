<?php

namespace App\Http\Models\Api\PlayerRanking;

class VoteRankingResolver extends RankingResolver
{
    const COMPARE_TARGET = 'p_vote';
    const RANKING_TYPE = 'vote';

    function getRankComparator()
    {
        return self::COMPARE_TARGET;
    }

    function getRankingType()
    {
        return self::RANKING_TYPE;
    }
}