<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Cookie;
use Log;

use Auth;
use Input;
use Redmine;

class IdeaFormController extends Controller
{
    /**
     * アイデア投稿フォームindex
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        try {

            // ユーザ情報を取得
            $user = $this->jms_login_auth()->getUser();
            Log::debug(__FUNCTION__.' : login user ->'.print_r($user, 1));

            return view(
                'ideaForm', [
                    'user'    => $user,
                ]
            );
        }
        // 未ログインの場合、例外としてキャッチする
        catch (\Exception $e) {
            Log::debug(print_r($e->getMessage(), 1));
            return redirect()->to('/login');
        }
    }

    /**
     * 投稿完了アクション
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit()
    {
        // クッキーが生きて入れば、投稿不可
        if (!empty($_COOKIE["count"])) {
            Log::debug('$count -> '.print_r($_COOKIE["count"], 1));
            return redirect('ideaForm')->with('message', "アイデアの連続投稿はご遠慮ください。\nしばらく時間を置いてから投稿をお願いします。");
        }
        // 投稿処理
        else {
            // パラメータ取得
            $idea =  Input::get('idea');

            // 空欄チェック
            if (empty($idea)) {
                return redirect('ideaForm')->with('message', 'アイディアの項目が空欄です。');
            }
            else {

                // ユーザ情報を取得
                $user = $this->jms_login_auth()->getUser();
                Log::debug(__FUNCTION__.' : login user -> '.print_r($user, 1));

                // Redmine連携
                $client = new Redmine\Client(env('REDMINE_URL'), env('REDMINE_KEY'));
                // チケット起票
                $client->issue->create([
                    'project_id'  => env('IDEA_FORM_PROJECT_ID'),
                    'tracker_id'  => env('IDEA_FORM_TRACKER_ID'),
                    'status_id'   => env('IDEA_FORM_STATUS_ID'),
                    'priority_id' => env('IDEA_FORM_PRIORITY_ID'),
                    'subject'     => '['.$user['preferred_username'].'] '.mb_strimwidth($idea, 0, 40),
                    'description' => $idea,
//                    'assigned_to' => 'user1',
                ]);

                // クッキーをクライアント(ブラウザ)へ保存+投稿完了画面を表示
                $cookie = \Cookie::make('count', md5(uniqid(mt_rand(), true)), 1);
                return Response::view('ideaSubmitted')->withCookie($cookie);
            }
        }
    }

}
