<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Input;
use DB;



class PlayerController extends Controller
{
    public function index($player_nm = null)
    {
        // 最終ログイン時間を取得
        Log::debug('$player_nm -> '.print_r($player_nm, 1));

        // プレイヤーデータを取得
        $player_data = DB::table('playerdata')->where('name', $player_nm)->first();

        // ページ独自JSの設定
        $assetJs = [
            asset('/js/total.js?new'),
            asset('js/base/Chart.min.js')
        ];

        return view('player', [
            'player_data' => $player_data,
            'assetJs'     => $assetJs,
        ]);

    }
}
