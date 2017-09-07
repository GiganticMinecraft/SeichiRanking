<?php

namespace App\Http\Controllers\Api\PlayerData;

/**
 * 建築量のリゾルバクラス
 * @package App\Http\Controllers\Api\PlayerData
 */
class BuildPlayerDataResolver extends RawPlayerDataResolver
{
    function getDataColumnName()
    {
        return "build_count";
    }
}