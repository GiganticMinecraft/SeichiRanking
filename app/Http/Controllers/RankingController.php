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
        // ページ独自CSSの設定
        $assetCss = [
//            asset('/css/index.css')
        ];

        // viewをセット
        return view(
            'index', [
                'assetJs'          => [                     // ページ独自のJSアセット
                    '/js/player-search.js',
                    '/js/jsx/ranking.js'
                ],
                'assetCss'         => $assetCss,            // 独自CSS
            ]
        );
    }
}
