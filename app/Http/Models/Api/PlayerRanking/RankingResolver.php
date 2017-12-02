<?php

namespace App\Http\Models\Api\PlayerRanking;

use App\Http\Models\Api\PlayerDataFacade;
use Illuminate\Database\Query\Builder;
use DB;
use Log;

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

        $dataFacade = PlayerDataFacade::getInstance();

        return [
            "player" => $ranked_player,
            "type" => $this->getRankingType(),
            "rank" => $player_rank,
            "data" => $dataFacade->resolveData($this->getRankingType(), $ranked_player->uuid),
            "lastquit" => $dataFacade->resolveData("lastquit", $ranked_player->uuid)["raw_data"]
        ];
    }

    /**
     * ランキング全体を取得するためのクエリを取得する
     * @return Builder
     */
    private function getRankingQuery()
    {
        $comparator = $this->getRankComparator();

        // ref. http://blog.phalusamil.com/entry/2015/09/23/094536
        return DB::table(DB::raw(<<<EOT
(SELECT $comparator, @rank AS rank, cnt, @rank := @rank + cnt FROM (SELECT @rank := 1) AS Dummy,
(SELECT $comparator, count(*) AS cnt FROM playerdata GROUP BY $comparator ORDER BY $comparator DESC) AS GroupBy
) AS Ranking
JOIN playerdata ON playerdata.$comparator = Ranking.$comparator
EOT
        ))
            // rankがなぜか文字列で取得されていたのでSIGNEDにキャスト
            ->selectRaw('name, uuid, CAST(rank AS SIGNED) as rank')
            ->orderBy('rank', 'ASC')
            ->orderBy('name');
    }

    /**
     * ランキングの一部を取得する
     * @param $offset integer オフセットの大きさ
     * @param $limit integer 取得するランキングのサイズ
     * @return array IPlayerRankの配列
     */
    public function getRanking($offset, $limit)
    {
        $sorted_players = $this->getRankingQuery()->limit($limit)->offset($offset)->get();

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
        $ranked_player = $this->getRankingQuery()->where('uuid', $player_uuid)->first();

        return $this->toPlayerRank($ranked_player);
    }

    /**
     * ランキングに含まれるプレーヤーの総数を返す。レコードが0又は向こうの場合は除外される。
     */
    public function getPlayerCount()
    {
        return DB::table('playerdata')
            ->select('uuid')
            ->where($this->getRankComparator(), '>', 0)
            ->count();
    }
}