<?php

namespace App\Http\Controllers;

class RankingController extends Controller
{
    /**
     * ランキングTOP
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // サーバーステータスの取得
        $server_status = $this->get_server_status();

        // ページ独自CSSの設定
        $assetCss = [
//            asset('/css/index.css')
        ];

        // viewをセット
        return view(
            'index', [
                'server_status'    => $server_status,       // サーバ接続人数の情報
                'assetCss'         => $assetCss,            // 独自CSS
            ]
        );
    }
}
