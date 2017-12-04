<?php
/**
 * お問い合わせフォーム
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\FormModel;

use Response;
use Cookie;
use Log;
use Validator;
use Auth;
use Session;
use DB;
use Carbon\Carbon;
use GuzzleHttp;

class inquiryFormController extends Controller
{
    const FORM_NM = 'inquiryForm';

    public function __construct()
    {
        $this->model = new FormModel();
    }

    /**
     * indexアクション
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        try {
            // ユーザ情報を取得
            $jms_user_info = $this->model->get_jms_user_info(self::FORM_NM);

            // 独自定義JS
            $assetJs = [
                '/js/inquiry.js'
            ];

            return view(
                'form.'.self::FORM_NM, [
                    'user'    => $jms_user_info,    // JMSユーザ情報
                    'assetJs' => $assetJs,          // 独自定義JS
                ]
            );
        }
        // 未ログインの場合、例外としてキャッチする
        catch (\Exception $e) {
            // セッションに戻り先URLをセット
            Session::put('callback_url', '/inquiryForm');

            Log::debug(print_r($e->getMessage(), 1));
            return redirect()->to('/login/jms');
        }
    }

    /**
     * 投稿完了アクション
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request)
    {
        Log::debug('$request -> '.print_r($request->input(), 1));

        // パラメータ取得
        $inquiry_text = $request->input('inquiry_text');
        $reply_type   = $request->input('reply_type');

        // 返信タイプのセット
        if ($reply_type == 'twitter') {
            $contact_id_label = 'Twitter ID';
            $type = 1;

        }
        elseif ($reply_type == 'discord') {
            $contact_id_label = 'Discord ID';
            $type = 2;

        }
        else {
            $contact_id_label = 'ID';
            $type = 9;
        }

        // バリデーションエラー時のメッセージをセット
        $messages = [
            'reply_type.in'         => '連絡先の値が不正です。',
            'contact_id.required'   => $contact_id_label.'は必須項目です。',
            'contact_id.discordid'  => 'Discord IDは 末尾に「#数字」を入力してください。(例:user_name#1234)',
            'contact_id.twitter'    => '入力したTwitter IDは存在しません。',
        ];

        // バリデーション処理
        Validator::make($request->all(), [
            'reply_type'   => 'required|in:twitter,discord',
            'contact_id'   => 'required|discordid',
            'inquiry_text' => 'required',
        ], $messages)->validate();


        // クッキーが生きて入れば、投稿不可
        if (!empty($_COOKIE["inquiry"])) {
            Log::debug('inquiry cookie -> '.print_r($_COOKIE["inquiry"], 1));
            return redirect('inquiryForm')->withErrors( "お問い合わせの連続投稿はご遠慮ください。");
        }

        // 投稿処理
        try {
            // ユーザ情報を取得
            $user = $this->jms_login_auth()->getUser();
            Log::debug(__FUNCTION__ . ' : login user -> ' . print_r($user, 1));

                // Discord Botにpostリクエスト
            $discord_content = "**[".$user['preferred_username']."]**\n".$inquiry_text;
            $client = new GuzzleHttp\Client();
            $client->post(
                env('DISCORD_INQUIRY_URL'),
                ['json' => ['content' => $discord_content]]
            );

            // 問い合わせデータ保存 (将来的に問い合わせ管理システムで利用する目的)
            DB::table('inquiry')->insert([
                'name' => $user['preferred_username'],
                'inquiry_text' => $inquiry_text,
                'inquiry_date' => Carbon::now(),
                'reply_type'   => $type,
                'contact_id'   => $request->input('contact_id'),
                'solved_flg'   => 0,
                'delete_flg'   => 0,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ]);

            // 二重投稿防止のcookieを生成
            $cookie = \Cookie::make('inquiry', md5(uniqid(mt_rand(), true)), 1);

            // cookieをクライアント(ブラウザ)へ保存 + 投稿完了画面へ遷移
            return redirect('/thanks')->withCookie($cookie)->with('message', 'お問い合わせありがとうございました。');
        }
            // 例外キャッチ
        catch (\Exception $e) {
            // セッションに戻り先URLをセット
            Session::put('callback_url', '/inquiryForm');

            Log::debug(print_r($e->getMessage(), 1));
            return redirect()->to('/login/jms');
        }

    }

}
