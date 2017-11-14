<?php

namespace App\Http\Models\Api\PlayerData;

/**
 * プレイ時間のリゾルバクラス
 * @package App\Http\Controllers\Api\PlayerData
 */
class PlaytimePlayerDataResolver extends PlayerDataResolver
{
    function getDataColumnName()
    {
        return "playtick";
    }

    /**
     * プレイ時間(tick)を時間を表す array に変換する
     * @param $playtick int プレイ時間(tick)
     * @return array PlayTimeを表す配列
     */
    private function toPlayTimeObject($playtick)
    {
        $play_seconds = intdiv($playtick, 20);
        $play_minutes = intdiv($play_seconds, 60);
        $play_hours = intdiv($play_minutes, 60);

        return [
            "hours" => $play_hours,
            "minutes" => $play_minutes % 60,
            "seconds" => $play_seconds % 60
        ];
    }

    function resolveData($player_uuid)
    {
        $raw_data = $this->fetchRawData($player_uuid);

        if ($raw_data === null) {
            return null;
        }

        return [
            "raw_data" => (string) $raw_data,
            "data" => $this->toPlayTimeObject($raw_data)
        ];
    }
}