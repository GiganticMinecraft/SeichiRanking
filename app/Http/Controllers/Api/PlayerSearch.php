<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PlayerSearch extends Controller
{
    const DEFAULT_LIMIT_VALUE = 5;
    const LIMIT_MAX = 20;

    public function get(Request $request)
    {
        $query = $request->input("q");
        $limit = (int) $request->input("lim") ?: self::DEFAULT_LIMIT_VALUE;

        // clamp limit
        $limit = max(1, min($limit, self::LIMIT_MAX));

        $players = DB::table('playerdata')
            ->select('name', 'uuid')
            ->where('name',  'like',  $query . '%')
            ->orderBy('name')
            ->limit($limit)
            ->get();

        return response()->json([
            'result_count' => count($players),
            'players' => $players
        ]);
    }
}