<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;
use Carbon\Carbon;
use GuzzleHttp;
use Auth;
use Mockery\Exception;
use Twitter;

class AdminModel extends Model
{
    /**
     * お問い合わせ一覧を取得する
     * @param Request $request
     * @param string $order_by
     * @return mixed
     */
    public function get_inquiry_list($request, $order_by='inquiry_date')
    {
        // パラメータ取得
        Log::debug('$request -> '.print_r($request->input(), 1));
        $params = $request->input();

        // 絞り込みラジオ
        $filter = null;
        if (isset($params['filter']) && $params['filter'] !== 'all') {
            $filter = $params['filter'];
        }

        // 検索キーワード
        $keyword = null;
        if (isset($params['word'])) {
            $keyword = $params['word'];
        }

        // クエリ発行
        $inquiry_list = DB::table('inquiry')
            ->where('delete_flg', 0)
            ->orderBy('inquiry_date', 'DESC')
            ->when(!empty($filter), function ($query) use ($filter) {
                return $query->where('solved_flg', $filter);
            })
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query
                    ->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('inquiry_text', 'LIKE', "%$keyword%");
            })
            ->orderBy('inquiry_id', 'DESC')
            ->paginate(20);

        return $inquiry_list;
    }

    /**
     * お問い合わせ詳細データを取得する
     * @param $request
     * @return mixed
     */
    public function get_inquiry_detail($request)
    {
        $inquiry_detail = DB::table('inquiry as i')
            ->select(
                'i.inquiry_id',     // 問い合わせID
                'i.name',           // 問い合わせしたMCID
                'i.inquiry_text',   // 問い合わせ内容
                'i.inquiry_date',   // 問い合わせ日時
                'i.reply_type',     // 返信タイプ
                'i.contact_id',     // 返信先ID
                'a.answer_text'     // 回答内容
            )
            ->join('inquiry_answer as a', 'i.inquiry_id', '=', 'a.inquiry_id', 'left outer')
            ->where('i.inquiry_id', $request->input('id'))
            ->first();  // 1行のみ取得

        return $inquiry_detail;
    }

    public function save_inquiry_answer($request)
    {
        try {
            // パラメータ取得
            $params = $request->input();
            Log::debug('$params -> '.print_r($params, 1));

            // 通知先IDを取得
            $inquiry_data = DB::table('inquiry')->select('contact_id')
                ->where('inquiry_id', (int)$params['inquiry_id'])
                ->first();
            $contact_id = $inquiry_data->contact_id;

            // Discordの#supportへの通知
            if ($params['discord_notice'] === 'true') {
                $discord_content = "<\@".$contact_id."> **さんへの回答** *(by ".Auth::user()->name.")*\n".$params['answer'];
                $client = new GuzzleHttp\Client();
                $client->post(
                    env('DISCORD_INQUIRY_ANSWER_URL'),
                    ['json' => ['content' => $discord_content]]
                );
            }

            // Twitterで回答を送信
            if (!empty($params['twitter_notice'])) {
                Log::debug('twitter_notice -> '.print_r($params['twitter_notice'], 1));

                // メンションの「@」記号チェック
                if (!preg_match('/^@.+$/', $contact_id)) {
                    $contact_id = '@'.$contact_id;
                }

                // Tweet
                Twitter::postTweet(['status' => $contact_id." \n".$params['answer'], 'format' => 'json']);
            }

            // 回答データ存在チェック
            $inquiry_answer_data = DB::table('inquiry_answer')
                ->select('inquiry_answer_id')
                ->where('inquiry_id', (int)$params['inquiry_id'])->first();
//            Log::debug('$inquiry_data -> ' .print_r($inquiry_data, 1));

            // 回答データ登録
            if (empty($inquiry_answer_data->inquiry_answer_id)) { // データが存在しない場合のみ
                DB::table('inquiry_answer')->insert([
                    'inquiry_id'  => $params['inquiry_id'],
                    'name'        => $params['name'],
                    'admin_id'    => Auth::user()->id,   // ログイン中の管理ユーザID
                    'answer_text' => $params['answer'],
                    'answer_date' => Carbon::now(),
                    'delete_flg'  => 0,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                ]);
            }
            else {
                DB::table('inquiry_answer')
                    ->where('inquiry_answer_id', $inquiry_answer_data->inquiry_answer_id)
                    ->update([
                    'inquiry_id'  => $params['inquiry_id'],
                    'name'        => $params['name'],
                    'admin_id'    => Auth::user()->id,   // ログイン中の管理ユーザID
                    'answer_text' => $params['answer'],
                    'answer_date' => Carbon::now(),
                    'delete_flg'  => 0,
                    'updated_at'  => Carbon::now(),
                ]);
            }

            // 問い合わせデータの「回答フラグ」を折る
            DB::table('inquiry')
                ->where('inquiry_id', $params['inquiry_id'])
                ->update([
                'solved_flg' => 1,  // 回答済
                'updated_at' => Carbon::now(),
            ]);

            return true;
        }
        catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * 管理者アカウント一覧を取得する
     * @return mixed
     */
    public function get_account_list()
    {
        $inquiry_list = DB::table('users')
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return $inquiry_list;
    }

}