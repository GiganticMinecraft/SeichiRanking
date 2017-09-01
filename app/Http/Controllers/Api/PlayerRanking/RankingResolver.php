<?php

namespace App\Http\Controllers\Api\PlayerRanking;

use DB;

abstract class RankingResolver
{
    abstract function getRankComparator();

    abstract function getRankingType();

    private function toPlayerRank($player)
    {
        $player_rank = $player->rank;
        unset($player->rank);
        return [
            "player" => $player,
            "type" => $this->getRankingType(),
            "rank" => $player_rank
        ];
    }

    public function getRanking($limit, $offset)
    {
        $comparator = $this->getRankComparator();

        // TODO this result should be cached for better response time
        $sorted_players = DB::table('playerdata as t1')
            ->select(
                'name',
                'uuid',
                DB::raw('(select count(*)+1 from playerdata as t2 where t2.' . $comparator . ' > t1.' . $comparator . ') as rank')
            )
            ->where($comparator, '>', 0)
            ->orderBy('rank', 'ASC')
            ->orderBy('name')
            ->get();

        $ranked_players = [];

        foreach ($sorted_players as $player) {
            $ranked_players[] = $this->toPlayerRank($player);
        }

        return array_slice($ranked_players, $offset - 1, $limit);
    }
}