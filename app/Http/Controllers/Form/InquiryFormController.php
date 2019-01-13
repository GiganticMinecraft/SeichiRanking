<?php
/**
 * お問い合わせフォーム
 */

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Rules\TwitterIdCheck;
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
use Redmine;


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
            $jms_user_info = $this->model->jms_login_auth();

            // 独自定義JS
            $assetJs = [
                '/js/inquiry.js'
            ];

            return view(
                'form.'.self::FORM_NM, [
                    'user'    => $jms_user_info->getUser(),    // JMSユーザ情報
                    'assetJs' => $assetJs,          // 独自定義JS
                ]
            );
        }
        // 未ログインの場合、例外としてキャッチする
        catch (\Exception $e) {
            // セッションに戻り先URLをセット
            Session::put('callback_url', '/inquiryForm');
            Log::debug('hoge');
            Log::error(__LINE__.print_r($e->getMessage(), 1));
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
        $contact_id   = $request->input('contact_id');

        $validate_rule = [];

        // 返信タイプのセット
        if ($reply_type == 'twitter') {
            $contact_id_label = 'Twitter ID';
            $type = 1;

            $validate_rule = [
                'reply_type'   => 'required|in:twitter,discord',
                'contact_id'   => ['required', new TwitterIdCheck],
                'inquiry_text' => 'required',
            ];
        }
        elseif ($reply_type == 'discord') {
            $contact_id_label = 'Discord ID';
            $type = 2;

            $validate_rule = [
                'reply_type'   => 'required|in:twitter,discord',
                'contact_id'   => 'required',
                'inquiry_text' => 'required',
            ];
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
        Validator::make($request->all(), $validate_rule, $messages)->validate();

        // クッキーが生きて入れば、投稿不可
        if (!empty($_COOKIE["inquiry"])) {
            Log::debug('inquiry cookie -> '.print_r($_COOKIE["inquiry"], 1));
            return redirect('inquiryForm')->withErrors( "お問い合わせの連続投稿はご遠慮ください。");
        }

        // 投稿処理
        try {
            // ユーザ情報を取得
            $user = $this->model->jms_login_auth()->getUser();
            Log::debug(__FUNCTION__ . ' : login user -> ' . print_r($user, 1));

            // Discord Botにpostリクエスト
//            $discord_content = "**[".$user['preferred_username']."]**\n".$inquiry_text;
//            $client = new GuzzleHttp\Client();
//            $client->post(
//                env('DISCORD_INQUIRY_URL'),
//                ['json' => ['content' => $discord_content]]
//            );

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

            // Redmine連携
            $client = new Redmine\Client(env('REDMINE_URL'), env('REDMINE_KEY'));

            // チケット起票
            $client->issue->create([
                'project_id'  => env('INQUIRY_FORM_PROJECT_ID'),
                'tracker_id'  => env('INQUIRY_FORM_TRACKER_ID'),
                'status_id'   => env('INQUIRY_FORM_STATUS_ID'),
                'priority_id' => env('INQUIRY_FORM_PRIORITY_ID'),
                'subject'     => '[' . $user['preferred_username'] . '] ' . mb_strimwidth($inquiry_text, 0, 40),
                'custom_fields' => [
                    ['id' => 1, 'value' => $reply_type . ':' . $contact_id],    // 連絡先
                    ['id' => 2, 'value' => $user['preferred_username']],        // MCID
                    ['id' => 9, 'value' => $user['uuid']],                      // uuid
                ],
                'description' => $inquiry_text,
//                'cf_1'        => $reply_type . ':' . $contact_id,
//                'cf_2'        => $user['preferred_username'],
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
