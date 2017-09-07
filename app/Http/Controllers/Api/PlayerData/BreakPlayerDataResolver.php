<?php

namespace App\Http\Controllers\Api\PlayerData;


class BreakPlayerDataResolver extends RawPlayerDataResolver
{
    function getDataColumnName()
    {
        return "totalbreaknum";
    }
}