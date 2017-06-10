<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

use Illuminate\Support\Facades\App;
use Log;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Libs\MojangAPI;

class RankingModel extends Model
{
    /**
     *
     * @return mixed
     */
    public function get_ranking_data()
    {
        $rank_data = DB::table('playerdata')->orderBy('totalbreaknum', 'DESC')->paginate(20);
        Log::debug($rank_data->total());

        // uuidをもとに、mob head 画像を配列へ代入
        foreach ($rank_data as $key => &$item) {
//            $item->mob_head_img = MojangAPI::embedImage(MojangAPI::getPlayerHead($item->uuid));
            $item->mob_head_img = 'https://mcapi.ca/avatar/' . $item->name . '/60';

            // 順位計算
            $item->rank = $rank_data->perPage() * ($rank_data->currentPage() - 1) + ($key + 1);
        }

//        $paginator = new LengthAwarePaginator($items, $total, $limit, $page);
        return $rank_data;
    }

    public function get_mob_head_image()
    {

    }
}
