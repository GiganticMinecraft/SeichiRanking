<?php

namespace App\Http\Models\Api\PlayerRanking;

class VoteRankingResolver extends RankingResolver
{
    const COMPARE_TARGET = 'p_vote';

    const TOTAL_TABLE_TARGET = 'playerdata';
    const TOTAL_COMPARE_TARGET = 'p_vote';

    const DAILY_TABLE_TARGET = 'daily_ranking_table';
    const DAILY_COMPARE_TARGET = 'vote_count';

    const WEEKLY_TABLE_TARGET = 'weekly_ranking_table';
    const WEEKLY_COMPARE_TARGET = 'break_count';

    const RANKING_TYPE = 'vote';

    /**
     * ランキングデータを取得するために利用するテーブル名を返却する
     * @return string
     */
    function getRankTable()
    {
        if (request('duration') === 'daily') {
            // デイリー
            return self::DAILY_TABLE_TARGET;
        } else {
            // 総合
            return self::TOTAL_TABLE_TARGET;
        }
    }

    /**
     * ランキングデータを取得するために利用するカラム名を返却する
     * @return string
     */
    function getRankComparator()
    {
        if (request('duration') === 'daily') {
            // デイリー
            return self::DAILY_COMPARE_TARGET;
        } else {
            // 総合
            return self::TOTAL_COMPARE_TARGET;
        }

    }

    function getRankingType()
    {
        return self::RANKING_TYPE;
    }
}