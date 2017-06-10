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
    public function index()
    {
        $ranking_data = $this->model->get_ranking_data();

        // ページ独自CSSの設定
        $assetCss = [
//            asset('/css/index.css')
        ];

        // viewをセット
        return view(
            'index', [
                'assetCss'     => $assetCss,
                'ranking_data' => $ranking_data
            ]
        );
    }
    //
}
