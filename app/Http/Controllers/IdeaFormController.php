<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Cookie;
use Log;

use Auth;
use Input;
use Redmine;
use MinecraftJP;

class IdeaFormController extends Controller
{
    /**
     * アイデア投稿フォームindex
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        try {
            $minecraftjp = new MinecraftJP(array(
                'clientId'     => env('JMS_CLIENT_ID'),
                'clientSecret' => env('JMS_CLIENT_SECRET'),
                'redirectUri'  => env('JMS_CALLBACK')
            ));
            // Get Access Token
//            $accessToken = $minecraftjp->getAccessToken();
//            Log::debug('$accessToken ->'.print_r($accessToken, 1));

            // Get User
            $user = $minecraftjp->getUser();
            Log::debug(print_r($user, 1));

            return view(
                'ideaForm', [
                    'user'    => $user,
                ]
            );
        }
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

                // Redmine連携
                $client = new Redmine\Client(env('REDMINE_URL'), 'corosuke2s', 'yhxdfa23');
//                $client->issue->create([
//                    'project_id'  => 'admin',
//                    'subject'     => 'テスト投稿です',
//                    'description' => $idea,
////                    'assigned_to' => 'user1',
//                ]);
                $client->issue->all([
                    'limit' => 1000
                ]);
                Log::debug('test -> '.print_r($client, 1));

                // クッキーをクライアント(ブラウザ)へ保存する
                $cookie = \Cookie::make('count', md5(uniqid(mt_rand(), true)), 1);
                return Response::view('ideaSubmitted')->withCookie($cookie);
            }
        }
    }

}
