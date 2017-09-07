<?php

namespace App\Http\Controllers\Api\PlayerData;


class BuildPlayerDataResolver extends RawPlayerDataResolver
{
    function getDataColumnName()
    {
        return "resolve";
    }
}