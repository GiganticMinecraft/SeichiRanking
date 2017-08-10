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
     * @param string $mode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($mode=null)
    {
        // 整地ランキングの取得
        $break_ranking = $this->model->get_break_ranking($mode);

        // 建築ランキングの取得
        $build_ranking = $this->model->get_build_ranking($mode);

        // ナビゲーションバーの判定
        $navbar_act = $this->model->set_navbar_act($mode);

        // サーバーステータスの取得
        $server_status = $this->get_server_status();

        // 未公開メニューのフラグセット (仮)


        // ページ独自CSSの設定
        $assetCss = [
//            asset('/css/index.css')
        ];

        // viewをセット
        return view(
            'index', [
                'assetCss'      => $assetCss,       // 独自CSS
                'break_ranking' => $break_ranking,  // 整地ランキング
                'build_ranking' => $build_ranking,  // 建築量ランキング
                'navbar_act'    => $navbar_act,
                'server_status' => $server_status,
            ]
        );
    }
    //
}
