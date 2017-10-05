<?php

namespace App\Http\Models\Api\PlayerRanking;

use DB;

abstract class RankingResolver
{
    abstract function getRankComparator();

    abstract function getRankingType();

    private function toPlayerRank($ranked_player)
    {
        if ($ranked_player == null) {
            return null;
        }

        $player_rank = $ranked_player->rank;
        unset($ranked_player->rank);
        return [
            "player" => $ranked_player,
            "type" => $this->getRankingType(),
            "rank" => $player_rank
        ];
    }

    /**
     * ランキング全体を取得する。
     * @return array IPlayerRankの配列
     */
    public function getRanking()
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

        return $ranked_players;
    }

    /**
     * 指定プレーヤーの順位を取得する
     * @param $player_uuid string プレーヤーのUUID
     * @return array|null IPlayerRankの配列/プレーヤーの順位が存在しない場合はnull
     */
    public function getPlayerRank($player_uuid)
    {
        $comparator = $this->getRankComparator();

        // TODO this query cannot be cached, but instead a (name => rank) map can be generated from all-players-ranking
        $ranked_player = DB::table('playerdata as t1')
            ->select(
                'name',
                'uuid',
                DB::raw('(select count(*)+1 from playerdata as t2 where t2.' . $comparator . ' > t1.' . $comparator . ') as rank')
            )
            ->where('uuid', $player_uuid)
            ->first();

        return $this->toPlayerRank($ranked_player);
    }
}