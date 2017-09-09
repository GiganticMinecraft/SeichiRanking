<?php

namespace App\Http\Controllers\Api\PlayerData;

use DB;

/**
 * プレーヤーデータAPIで返却するデータのリゾルバクラス
 * @package App\Http\Controllers\Api\PlayerData
 */
abstract class PlayerDataResolver
{
    /**
     * @return string DB内でデータに対応するカラムの名前
     */
    abstract function getDataColumnName();

    /**
     * @param $player_uuid string 対象プレーヤーのUUID文字列
     * @return array プレーヤーAPIにて策定されたフォーマットを持つ array
     */
    abstract function resolveData($player_uuid);

    /**
     * DBから対応するデータを取得する
     * @param $player_uuid string 対象プレーヤーのUUID文字列
     * @return mixed DBから取得した生の値。レコードが存在しない場合はnull
     */
    protected function fetchRawData($player_uuid) {
        return DB::table('playerdata')
            ->where('uuid', '=', $player_uuid)
            ->value($this->getDataColumnName());
    }
}