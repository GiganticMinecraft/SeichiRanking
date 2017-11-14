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
use Validator;
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
            return redirect()->to('/login/jms');
        }
    }

    /**
     * 投稿完了アクション
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request)
    {
        // クッキーが生きて入れば、投稿不可
        if (!empty($_COOKIE["idea"])) {
            Log::debug('idea cookie -> '.print_r($_COOKIE["idea"], 1));
            return redirect()->back()->withErrors(['idea_text' => "アイデアの連続投稿はご遠慮ください。しばらく時間を置いてから投稿をお願いします。"]);
        }
        // 投稿処理
        else {
            // パラメータ取得
            $idea_text    = Input::get('idea_text');
            $idea_reason  = Input::get('idea_reason');
            $idea_example = Input::get('idea_example');

            // チケット説明文の整形
            $description  = 'h3. ◇' . __('label.idea_text') . "\n\n";
            $description .= '* ' . $idea_text . "\n\n";
            $description .= 'h3. ◇' . __('label.idea_reason') . "\n\n";
            $description .= '* ' . $idea_reason . "\n\n";
            $description .= 'h3. ◇' . __('label.idea_example') . "\n\n";
            $description .= '* ' . $idea_example;

            // 空欄チェック
            $this->validate($request, [
                'idea_text'    => 'required',
                'idea_reason'  => 'required',
                'idea_example' => 'required',
            ]);

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
                    'subject'     => '[' . $user['preferred_username'] . '] ' . mb_strimwidth($idea_text, 0, 40),
                    'description' => $description,
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
                return redirect()->to('/login/jms');
            }
        }
    }

}
