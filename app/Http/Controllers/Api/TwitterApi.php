<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Thujohn\Twitter\Facades\Twitter;
use Illuminate\Support\Facades\Log;

class TwitterApi extends Controller
{
    /**
     * Twitter IDが存在しているかどうかを返す
     * @param $screen_name
     */
    public function checkTwitterId($screen_name)
    {
        try {
            $result = Twitter::getUsers(['screen_name' => $screen_name, 'format' => 'array']);
        }
        catch (\Exception $e) {
            $result = null;
        }

        return response()->json($result);
    }

}
