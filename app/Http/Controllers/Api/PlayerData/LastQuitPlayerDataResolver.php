<?php

namespace App\Http\Controllers\Api\PlayerData;

/**
 * 最終ログアウト時間のリゾルバクラス
 * @package App\Http\Controllers\Api\PlayerData
 */
class LastQuitPlayerDataResolver extends RawPlayerDataResolver
{
    /**
     * @return string DB内でデータに対応するカラムの名前
     */
    function getDataColumnName()
    {
        return "lastquit";
    }
}