<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Api\PlayerData\BreakPlayerDataResolver;
use App\Http\Controllers\Api\PlayerData\BuildPlayerDataResolver;
use App\Http\Controllers\Api\PlayerData\PlaytimePlayerDataResolver;
use App\Http\Controllers\Api\PlayerData\VotePlayerDataResolver;
use App\Http\Controllers\Controller;

/**
 * プレーヤーデータAPIのコントローラクラス
 * @package App\Http\Controllers\Api
 */
class PlayerData extends Controller
{
    /** データのリゾルバを格納するための連想配列 */
    private $resolvers;

    public function __construct()
    {
        $this->resolvers = [
            "break" => new BreakPlayerDataResolver(),
            "build" => new BuildPlayerDataResolver(),
            "playtime" => new PlaytimePlayerDataResolver(),
            "vote" => new VotePlayerDataResolver()
        ];
    }

    /**
     * 指定したUUIDを持つプレーヤーの指定したデータを取得する。

     * @param $player_uuid
     * @param $data_type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlayerData($player_uuid, $data_type)
    {
        $resolver = $this->resolvers[$data_type];

        // データタイプが未定義の場合
        if ($resolver == null) {
            return response()->json(["message" => "requested data type does not exist."], 404);
        }

        $data = $resolver->resolveData($player_uuid);

        // データが見つからなかった場合
        if ($data == null) {
            return response()->json(["message" => "requested record does not exist."], 404);
        }

        return response()->json($data);
    }
};