<?php
/**
 * Created by PhpStorm.
 * User: Kory
 * Date: 9/15/2017
 * Time: 12:15 PM
 */

namespace App\Http\Controllers\Api\PlayerData;

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