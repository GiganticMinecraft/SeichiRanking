<?php

namespace App\Http\Controllers\Api\PlayerData;

/**
 * 投票数のリゾルバクラス
 * @package App\Http\Controllers\Api\PlayerData
 */
class VotePlayerDataResolver extends RawPlayerDataResolver
{
    function getDataColumnName()
    {
        return "p_vote";
    }
}