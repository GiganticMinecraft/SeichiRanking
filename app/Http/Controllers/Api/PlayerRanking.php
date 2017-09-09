<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\PlayerRanking\BreakRankingResolver;
use App\Http\Controllers\Api\PlayerRanking\BuildRankingResolver;
use App\Http\Controllers\Api\PlayerRanking\PlaytimeRankingResolver;
use App\Http\Controllers\Api\PlayerRanking\VoteRankingResolver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlayerRanking extends Controller
{
    const DEFAULT_LIMIT_VALUE = 100;
    const LIMIT_MAX = 100;

    const DEFAULT_OFFSET_VALUE = 1;

    const DEFAULT_RANKING_TYPES = "break,build,playtime,vote";

    private $resolvers;

    public function __construct()
    {
        $this->resolvers = [
            "break" => new BreakRankingResolver(),
            "build" => new BuildRankingResolver(),
            "playtime" => new PlaytimeRankingResolver(),
            "vote" => new VoteRankingResolver()
        ];
    }

    private function isValidRankingType($ranking_type)
    {
        return isset($this->resolvers[$ranking_type]);
    }

    private function fetchRankingResolver($ranking_type)
    {
        if($this->isValidRankingType($ranking_type)) {
            return $this->resolvers[$ranking_type];
        }

        // デフォルトで破壊量ランキングのリゾルバを使用する
        return $this->resolvers["break"];
    }

    public function get(Request $request)
    {
        $ranking_type = $request->input("type") ?: "default";

        $limit = (int) $request->input("lim") ?: self::DEFAULT_LIMIT_VALUE;
        $limit = max(1, min($limit, self::LIMIT_MAX));

        $offset = (int) $request->input("offset") ?: self::DEFAULT_OFFSET_VALUE;
        $offset = max(1, $offset);

        $ranks = $this->fetchRankingResolver($ranking_type)->getRanking($limit, $offset);

        return response()->json([
            'result_count' => count($ranks),
            'ranks' => $ranks
        ]);
    }

    public function getPlayerRank(Request $request, $player_uuid)
    {
        $ranking_resolvers = array();
        $ranking_types = $request->input("types") ?: self::DEFAULT_RANKING_TYPES;

        foreach (explode(",", $ranking_types) as $ranking_type) {
            if ($this->isValidRankingType($ranking_type)) {
                $ranking_resolvers[$ranking_type] = $this->fetchRankingResolver($ranking_type);
            }
        }

        $ranks = array();
        foreach ($ranking_resolvers as $resolver) {
            $rank = $resolver->getPlayerRank($player_uuid);

            if ($rank == null) {
                return response()->json(["message" => "requested data does not exist."], 404);
            }

            $ranks[] = $rank;
        }

        return response()->json($ranks);
    }
}