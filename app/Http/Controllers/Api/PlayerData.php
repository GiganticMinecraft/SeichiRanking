<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models\Api\PlayerDataFacade;

/**
 * プレーヤーデータAPIのコントローラクラス
 * @package App\Http\Controllers\Api
 */
class PlayerData extends Controller
{
    /**
     * 指定したUUIDを持つプレーヤーの指定したデータを取得する。
     * @param $player_uuid
     * @param $data_type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlayerData($player_uuid, $data_type)
    {
        $facade = PlayerDataFacade::getInstance();

        // データタイプが未定義の場合
        if (!$facade->isValidMode($data_type)) {
            return response()->json(["message" => "requested data type does not exist."], 404);
        }

        $data = $facade->resolveData($data_type, $player_uuid);

        // データが見つからなかった場合
        if ($data === null) {
            return response()->json(["message" => "requested record does not exist."], 404);
        }

        return response()->json($data);
    }
};