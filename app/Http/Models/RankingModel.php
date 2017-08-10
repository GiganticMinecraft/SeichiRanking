<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

use Illuminate\Support\Facades\App;
use Log;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Libs\MojangAPI;
use Illuminate\Pagination\Paginator;
use Input;

use Route;

class RankingModel extends Model
{
    /**
     * 整地量ランキングデータ取得
     * @param string $mode total / year / monthly / weekly / daily
     * @return mixed
     */
    public function get_break_ranking($mode)
    {
        // to-do: 総合ランキング以外にも対応する
        Log::debug('$mode -> '.$mode);

        // クエリ発行＋ページャ作成
        $this->set_current_page('break');
        $rank_data = DB::table('playerdata as t1')
            ->select(
                'name',             // MCID
                'totalbreaknum',    // 総整地量
                'lastquit',         // 最終ログイン時間
                // スキン画像をAPI経由で取得
                DB::raw("(CONCAT('https://mcapi.ca/avatar/', name, '/60')) as mob_head_img"),
                // 順位計算
                DB::raw('(select count(*)+1 from playerdata as t2 where t2.totalbreaknum > t1.totalbreaknum) as rank')
            )
            ->where('totalbreaknum', '>', 0)
            ->orderBy('totalbreaknum', 'DESC')  // 第1ソート：総整地量 (降順)
            ->orderBy('name')                   // 第2ソート：MCID (昇順)
            ->paginate(20);

        return $rank_data;
    }

    /**
     * 建築量ランキングデータ取得
     * @param string $mode total / year / monthly / weekly / daily
     * @return mixed
     */
    public function get_build_ranking($mode)
    {
        // to-do: 総合ランキング以外にも対応する
        Log::debug('$mode -> '.$mode);

        // クエリ発行＋ページャ作成
        $this->set_current_page('build');
        $rank_data = DB::table('playerdata as t1')
            ->select(
                'name',             // MCID
                'build_count',      // 総建築量
                'lastquit',         // 最終ログイン時間
                // スキン画像をAPI経由で取得
                DB::raw("(CONCAT('https://mcapi.ca/avatar/', name, '/60')) as mob_head_img"),
                // 順位計算
                DB::raw('(select count(*)+1 from playerdata as t2 where t2.build_count > t1.build_count) as rank')
            )
            ->where('build_count', '>', 0)
            ->orderBy('build_count', 'DESC')  // 第1ソート：総建築量 (降順)
            ->orderBy('name')                 // 第2ソート：MCID (昇順)
            ->paginate(20);

        return $rank_data;
    }

    /**
     * 接続時間ランキングデータ取得
     * @param string $mode total / year / monthly / weekly / daily
     * @return mixed
     */
    public function get_playtime_ranking($mode)
    {
        // to-do: 総合ランキング以外にも対応する
        Log::debug('$mode -> '.$mode);

        // クエリ発行＋ページャ作成
        $this->set_current_page('playtime');
        $rank_data = DB::table('playerdata as t1')
            ->select(
                'name', // MCID
                DB::raw('(SEC_TO_TIME(playtick/20)) as playtime'),  // プレイ時間
                'lastquit', // 最終ログイン時間
                // スキン画像をAPI経由で取得
                DB::raw("(CONCAT('https://mcapi.ca/avatar/', name, '/60')) as mob_head_img"),
                // 順位計算
                DB::raw('(select count(*)+1 from playerdata as t2 where t2.playtime > t1.playtime) as rank')
            )
            ->where('playtime', '>', 0)
            ->orderBy('playtime', 'DESC')  // 第1ソート：総建築量 (降順)
            ->orderBy('name')                 // 第2ソート：MCID (昇順)
            ->paginate(20);

        return $rank_data;
    }

    /**
     * 投票数ランキングデータ取得
     * @param string $mode total / year / monthly / weekly / daily
     * @return mixed
     */
    public function get_vote_ranking($mode)
    {
        // to-do: 総合ランキング以外にも対応する
        Log::debug('$mode -> '.$mode);

        // クエリ発行＋ページャ作成
        $this->set_current_page('vote');
        $rank_data = DB::table('playerdata as t1')
            ->select(
                'name',     // MCID
                'p_vote',   // 総投票数
                'lastquit', // 最終ログイン時間
                // スキン画像をAPI経由で取得
                DB::raw("(CONCAT('https://mcapi.ca/avatar/', name, '/60')) as mob_head_img"),
                // 順位計算
                DB::raw('(select count(*)+1 from playerdata as t2 where t2.p_vote > t1.p_vote) as rank')
            )
            ->where('p_vote', '>', 0)
            ->orderBy('p_vote', 'DESC')  // 第1ソート：総投票数 (降順)
            ->orderBy('name')            // 第2ソート：MCID (昇順)
            ->paginate(20);

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

    /**
     * ページャに対してランキング毎のページ番号をセットする
     * @param string $rank_kind ランキングの種類
     * @return void
     */
    public function set_current_page($rank_kind)
    {
        // ランキング種別のGETパラメータを取得
        $param_kind = Input::get('kind');

        // GETパラメータで指定されたランキングの場合
        if ($rank_kind == $param_kind) {
            // ページ番号をセット
            $current_page = Input::get('page');
        }
        else {
            $current_page = 1;
        }

        // ページネータにページ番号をセット
        Paginator::currentPageResolver(function() use ($current_page) {
            return $current_page;
        });
    }

}
