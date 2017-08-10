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
            $rank_data = DB::table('playerdata as t1')
                ->select(
                    'name',             // MCID
                    'totalbreaknum',    // 総合整地量
                    'lastquit',
                    // 順位計算
                    DB::raw('(select count(*)+1 from playerdata as t2 where t2.totalbreaknum > t1.totalbreaknum) as rank')
                )
                ->where('totalbreaknum', '>', 0)
                ->orderBy('totalbreaknum', 'DESC')
                ->paginate(20);

            foreach ($rank_data as $key => &$item) {
                // API経由でスキン画像を取得
//            $item->mob_head_img = MojangAPI::embedImage(MojangAPI::getPlayerHead($item->uuid));
                $item->mob_head_img = 'https://mcapi.ca/avatar/' . $item->name . '/60';

                // 順位計算
//                $item->rank = DB::table('playerdata')->where('totalbreaknum', 'John')->first();
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
