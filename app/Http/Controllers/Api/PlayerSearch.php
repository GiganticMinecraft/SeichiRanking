<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PlayerSearch extends Controller
{
    const DEFAULT_LIMIT_VALUE = 5;
    const LIMIT_MAX = 20;

    private function to_json_result($query, $search_result = []) {
        return response()->json([
            'result_count' => count($search_result),
            'query' => $query,
            'players' => $search_result
        ]);
    }

    public function get(Request $request)
    {
        $query = $request->input("q");
        $limit = (int) $request->input("lim") ?: self::DEFAULT_LIMIT_VALUE;

        // clamp limit
        $limit = max(1, min($limit, self::LIMIT_MAX));

        if ($query == null) {
            return $this->to_json_result($query);
        }

        $players = DB::table('playerdata')
            ->select('name', 'uuid')
            ->where('name',  'like', str_replace(array('\\', '%', '_'), array('\\\\', '\%', '\_'), $query)  . '%')
            ->orderBy('name')
            ->limit($limit)
            ->get();

        return $this->to_json_result($query, $players);
    }
}