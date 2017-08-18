<?php
/**
 * アイディア投稿フォーム
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Cookie;
use Log;
use Auth;
use Input;
use Session;
use Redmine;

class IdeaFormController extends Controller
{
    /**
     * indexアクション
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
            // セッションに戻り先URLをセット
            Session::put('callback_url', '/ideaForm');

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
        if (!empty($_COOKIE["idea"])) {
            Log::debug('idea cookie -> '.print_r($_COOKIE["idea"], 1));
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

            // 投稿処理
            try {
                // ユーザ情報を取得
                $user = $this->jms_login_auth()->getUser();
                Log::debug(__FUNCTION__ . ' : login user -> ' . print_r($user, 1));

                // Redmine連携
                $client = new Redmine\Client(env('REDMINE_URL'), env('REDMINE_KEY'));
                // チケット起票
                $client->issue->create([
                    'project_id'  => env('IDEA_FORM_PROJECT_ID'),
                    'tracker_id'  => env('IDEA_FORM_TRACKER_ID'),
                    'status_id'   => env('IDEA_FORM_STATUS_ID'),
                    'priority_id' => env('IDEA_FORM_PRIORITY_ID'),
                    'subject'     => '[' . $user['preferred_username'] . '] ' . mb_strimwidth($idea, 0, 40),
                    'description' => $idea,
//                    'assigned_to' => 'user1',
                ]);

                // クッキーを生成
                $cookie = \Cookie::make('idea', md5(uniqid(mt_rand(), true)), 1);

                // cookieをクライアント(ブラウザ)へ保存 + 投稿完了画面へ遷移
                return redirect('/thanks')->withCookie($cookie)->with('message', 'アイディアの投稿、ありがとうございました。');
            }
            // 未ログインの場合、例外としてキャッチする
            catch (\Exception $e) {
                // セッションに戻り先URLをセット
                Session::put('callback_url', '/ideaForm');

                Log::debug(print_r($e->getMessage(), 1));
                return redirect()->to('/login');
            }
        }
    }

}
