<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\RankingModel;

class RankingController extends Controller
{
    public function __construct()
    {
        $this->model = new RankingModel();
    }

    /**
     * ランキングTOP
     * @param null $mode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($mode=null)
    {
        // ランキングデータを取得
        $ranking_data = $this->model->get_ranking_data($mode);

        // ナビゲーションバーの判定
        $navbar_act = $this->model->set_navbar_act($mode);

        // サーバーステータスの取得
        $server_status = $this->get_server_status();

        // ページ独自CSSの設定
        $assetCss = [
//            asset('/css/index.css')
        ];

        // viewをセット
        return view(
            'index', [
                'assetCss'      => $assetCss,
                'ranking_data'  => $ranking_data,
                'navbar_act'    => $navbar_act,
                'server_status' => $server_status,
            ]
        );
    }
    //
}
