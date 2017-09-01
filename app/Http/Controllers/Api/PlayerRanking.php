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

    private $resolvers;

    public function __construct()
    {
        $this->resolvers = [
            "default" => new BreakRankingResolver(),
            "build" => new BuildRankingResolver(),
            "playtime" => new PlaytimeRankingResolver(),
            "vote" => new VoteRankingResolver()
        ];
    }

    private function toJsonResult($ranks_result = [])
    {
        return response()->json([
            'result_count' => count($ranks_result),
            'ranks' => $ranks_result
        ]);
    }

    private function fetch_ranking($ranking_type, $limit, $offset)
    {
        $resolver = isset($this->resolvers[$ranking_type]) ? $this->resolvers[$ranking_type] : $this->resolvers["default"];
        return $resolver->getRanking($limit, $offset);
    }

    public function get(Request $request)
    {
        $ranking_type = $request->input("type") ?: "default";

        $limit = (int) $request->input("lim") ?: self::DEFAULT_LIMIT_VALUE;
        $limit = max(1, min($limit, self::LIMIT_MAX));

        $offset = (int) $request->input("offset") ?: self::DEFAULT_OFFSET_VALUE;
        $offset = max(1, $offset);

        $ranks = $this->fetch_ranking($ranking_type, $limit, $offset);
        return $this->toJsonResult($ranks);
    }
}