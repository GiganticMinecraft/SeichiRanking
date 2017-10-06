<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models\Api\PlayerRankingFacade;
use Illuminate\Http\Request;

class PlayerRanking extends Controller
{
    const DEFAULT_LIMIT_VALUE = 100;
    const LIMIT_MAX = 100;
    const DEFAULT_OFFSET_VALUE = 0;

    const DEFAULT_PLAYER_RANK_TYPES = "break,build,playtime,vote";

    public function get(Request $request)
    {
        $facade = PlayerRankingFacade::getInstance();

        $ranking_type = $request->input("type");
        if (!$facade->isValidMode($ranking_type)) {
            $ranking_type = "break";
        }

        $limit = (int) $request->input("lim") ?: self::DEFAULT_LIMIT_VALUE;
        $limit = max(1, min($limit, self::LIMIT_MAX));

        $offset = (int) $request->input("offset") ?: self::DEFAULT_OFFSET_VALUE;
        $offset = max(0, $offset);

        $entire_ranking = $facade->getRanking($ranking_type);
        $sub_ranking = array_slice($entire_ranking, $offset, $limit);

        return response()->json([
            'result_count' => count($sub_ranking),
            'ranks' => $sub_ranking,
            'total_ranked_player' => count($entire_ranking)
        ]);
    }

    public function getPlayerRank(Request $request, $player_uuid)
    {
        $facade = PlayerRankingFacade::getInstance();

        $ranks = array();
        $ranking_types = $request->input("types") ?: self::DEFAULT_PLAYER_RANK_TYPES;

        foreach (explode(",", $ranking_types) as $ranking_type) {
            if (!$facade->isValidMode($ranking_type)) {
                continue;
            }

            $rank = $facade->getPlayerRank($ranking_type, $player_uuid);

            if ($rank === null) {
                return response()->json(["message" => "requested data does not exist."], 404);
            }

            $ranks[] = $rank;
        }

        return response()->json($ranks);
    }
}