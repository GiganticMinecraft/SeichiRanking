<?php

namespace App\Http\Models\Api\PlayerRanking;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Query\Builder;

abstract class RankingResolver
{
    abstract function getRankComparator();

    abstract function getRankTable();

    abstract function getRankingType();

    /**
     * DBから取得した生のデータカラムをIPlayerData構造体に変換する
     * @param $raw_column mixed
     * @return array IPlayerDataの仕様に従ったarray
     * @internal param int $playtick プレイ時間(tick)
     */
    protected function toPlayerDataObject($raw_column) {
        return [
            'raw_data' => "$raw_column"
        ];
    }

    private function toPlayerRank($fetched_player_row)
    {
        if ($fetched_player_row == null) {
            return null;
        }

        return [
            "player" => [
                'name' => $fetched_player_row->name,
                'uuid' => $fetched_player_row->uuid,
            ],
            "type" => $this->getRankingType(),
            "rank" => $fetched_player_row->rank,
            "data" => $this->toPlayerDataObject($fetched_player_row->data),
            "lastquit" => $fetched_player_row->lastquit
        ];
    }

    private function getSearchPeriod($table){
        switch ($table){
            case "daily_ranking_table":
                return "WHERE $table.count_date = CURDATE()";
            case "weekly_ranking_table":
                return "WHERE YEARWEEK($table.count_date) = YEARWEEK(CURDATE())";
            case "monthly_ranking_table":
                return "WHERE DATE_FORMAT($table.count_date, '%Y%m') = DATE_FORMAT(NOW(), '%Y%m')";
            case "yearly_ranking_table":
                return "WHERE DATE_FORMAT($table.count_date, '%Y') = DATE_FORMAT(NOW(), '%Y')";
            default:
                return "";
        }
    }

    /**
     * ランキング全体を取得するためのクエリを取得する
     * @return Builder $query
     */
    private function getRankingQuery()
    {
        $comparator = $this->getRankComparator();
        logger('$comparator -> '.print_r($comparator, 1));

        $table = $this->getRankTable();
        logger('$table -> '.print_r($table, 1));

        $search_period = $this->getSearchPeriod($table);

        // 最終ログイン日時を取得
        $sql = <<<EOT
(SELECT $comparator, @rank AS rank, cnt, @rank := @rank + cnt FROM (SELECT @rank := 1) AS Dummy,
(SELECT $comparator, count(*) AS cnt FROM $table $search_period GROUP BY $comparator ORDER BY $comparator DESC) AS GroupBy
) AS Ranking
JOIN $table ON $table.$comparator = Ranking.$comparator
EOT;

        // ref. http://blog.phalusamil.com/entry/2015/09/23/094536
        $query = DB::table(DB::raw($sql))
            // rankがなぜか文字列で取得されていたのでSIGNEDにキャスト
            ->selectRaw("$table.name, $table.uuid, CAST(rank AS SIGNED) as rank, $table.$comparator as data, playerdata.lastquit as lastquit")
            ->where("$table.$comparator", '>', 0)
            ->orderBy('rank', 'ASC')
            ->orderBy('name');

        if ($table !== 'playerdata') {
            // 最終ログイン日時を取得
            $query->leftJoin('playerdata', DB::raw('playerdata.uuid collate utf8_general_ci'), '=', "$table.uuid");

            switch ($table) {
                case 'daily_ranking_table':
                    $query->where("$table.count_date", date('Y-m-d'));
                    break;
                case 'weekly_ranking_table':
                    Carbon::setWeekStartsAt(Carbon::SUNDAY);
                    Carbon::setWeekEndsAt(Carbon::SATURDAY);
                    $query->wherebetween("$table.count_date", [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'monthly_ranking_table':
                    $query->whereYear("$table.count_date", Carbon::now()->year);
                    $query->whereMonth("$table.count_date", Carbon::now()->month);
                    break;
                case 'yearly_ranking_table':
                    $query->whereYear("$table.count_date", Carbon::now()->year);
                    break;
            }
        }

        logger('getRankingQuery -> '.$query->toSql());

        return $query;
    }

    /**
     * ランキングの一部を取得する
     * @param $offset integer オフセットの大きさ
     * @param $limit integer 取得するランキングのサイズ
     * @return array IPlayerRankの配列
     */
    public function getRanking($offset, $limit)
    {
        $fetched_player_rows = $this->getRankingQuery()->limit($limit)->offset($offset)->get();

        $ranked_players = [];

        foreach ($fetched_player_rows as $player_row) {
            $ranked_players[] = $this->toPlayerRank($player_row);
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
        $player_row = $this->getRankingQuery()->where('uuid', $player_uuid)->first();

        return $this->toPlayerRank($player_row);
    }

    /**
     * ランキングに含まれるプレーヤーの総数を返す。レコードが0又は無効の場合は除外される。
     */
    public function getPlayerCount()
    {
        $table = $this->getRankTable();

        $query = DB::table($table)
            ->select('uuid')
            ->where($this->getRankComparator(), '>', 0);

        switch ($table) {
            case 'daily_ranking_table':
                $query->where("$table.count_date", date('Y-m-d'));
                break;
            case 'weekly_ranking_table':
                Carbon::setWeekStartsAt(Carbon::SUNDAY);
                Carbon::setWeekEndsAt(Carbon::SATURDAY);
                $query->wherebetween("$table.count_date", [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'monthly_ranking_table':
                $query->whereYear("$table.count_date", Carbon::now()->year);
                $query->whereMonth("$table.count_date", Carbon::now()->month);
                break;
            case 'yearly_ranking_table':
                $query->whereYear("$table.count_date", Carbon::now()->year);
                break;
        }
        return $query->count();
    }
}