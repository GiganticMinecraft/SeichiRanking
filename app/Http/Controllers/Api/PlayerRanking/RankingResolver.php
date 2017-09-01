<?php

namespace App\Http\Controllers\Api\PlayerRanking;

use DB;

abstract class RankingResolver
{
    abstract function getRankComparator();

    abstract function getRankingType();

    private function toPlayerRank($player, $rank)
    {
        return [
            "player" => $player,
            "type" => $this->getRankingType(),
            "rank" => $rank + 1
        ];
    }

    public function getRanking($limit, $offset)
    {
        $comparator = $this->getRankComparator();

        // TODO this result should be cached for better response time
        $sorted_players = DB::table('playerdata as t1')
            ->select('name', 'uuid')
            ->where($comparator, '>', 0)
            ->orderBy($comparator, 'DESC')
            ->orderBy('name')
            ->get();

        $playerRanks = [];

        foreach ($sorted_players as $rank=>$player) {
            $playerRanks[] = $this->toPlayerRank($player, $rank);
        }

        return array_slice($playerRanks, $offset - 1, $limit);
    }
}