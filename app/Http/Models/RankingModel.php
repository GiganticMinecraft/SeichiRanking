<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

use Illuminate\Support\Facades\App;
use Log;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Libs\MojangAPI;

use Route;

class RankingModel extends Model
{
    /**
     * ランキングデータ取得処理
     * @param string $mode total or daily
     * @return mixed
     */
    public function get_ranking_data($mode)
    {
//        Log::debug('$mode -> '.$mode);

//        if ($mode == 'total') {
            // クエリ発行＋ページャ作成
//            $rank_data = DB::table('mineblock')->orderBy('allmineblock', 'DESC')->paginate(20);
            $rank_data = DB::table('playerdata')->orderBy('totalbreaknum', 'DESC')->paginate(20);

            foreach ($rank_data as $key => &$item) {
//            $item->mob_head_img = MojangAPI::embedImage(MojangAPI::getPlayerHead($item->uuid));
                // API経由でスキン画像を取得
                $item->mob_head_img = 'https://mcapi.ca/avatar/' . $item->name . '/60';

                // 順位計算
                $item->rank = $rank_data->perPage() * ($rank_data->currentPage() - 1) + ($key + 1);
            }

//        }

        return $rank_data;
    }

    /**
     * ランキングモードを判定し、アクティブなランキングを判定
     * @param string $mode ランキングのモード
     * @return string $navbar_act アクティブなナビゲーションバーの名前
     */
    public function set_navbar_act($mode)
    {
        if ($mode == 'year') {
            $navbar_act = 'year';
        }
        elseif($mode == 'monthly') {
            $navbar_act = 'monthly';
        }
        elseif($mode == 'weekly') {
            $navbar_act = 'weekly';
        }
        elseif($mode == 'daily') {
            $navbar_act = 'daily';
        }
        // mode指定なし、またはtotal
        else {
            $navbar_act = 'total';
        }

        return $navbar_act;
    }

}
