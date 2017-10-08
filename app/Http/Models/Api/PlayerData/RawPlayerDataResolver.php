<?php

namespace App\Http\Models\Api\PlayerData;

/**
 * 生のデータを返却するのみのリゾルバクラス
 * @package App\Http\Controllers\Api\PlayerData
 */
abstract class RawPlayerDataResolver extends PlayerDataResolver
{
    function resolveData($player_uuid)
    {
        $raw_data = $this->fetchRawData($player_uuid);

        if ($raw_data === null) {
            return null;
        }

        return ["raw_data" => (string) $raw_data];
    }
}