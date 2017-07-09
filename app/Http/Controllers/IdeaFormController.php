<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Cookie;
use Log;

use Auth;
use MinecraftJP;

class IdeaFormController extends Controller
{
    /**
     * アイデア投稿フォームindex
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $message = null;

        try {
            $minecraftjp = new MinecraftJP(array(
                'clientId'     => env('JMS_CLIENT_ID'),
                'clientSecret' => env('JMS_CLIENT_SECRET'),
                'redirectUri'  => env('JMS_CALLBACK')
            ));
            // Get Access Token
            $accessToken = $minecraftjp->getAccessToken();
//            Log::debug('$accessToken ->'.print_r($accessToken, 1));

            // Get User
            $user = $minecraftjp->getUser();
//            Log::debug(print_r($user, 1));


            return view(
                'ideaForm', [
                    'message' => $message,
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
        // クッキーが生きて入れば
        if (!empty($_COOKIE["count"])) {
            Log::debug('$count -> '.print_r($_COOKIE["count"], 1));
            return redirect('ideaForm')->with('message', "アイデアの連続投稿はご遠慮ください。\nしばらく時間を置いてから投稿をお願いします。");
        }
        else {
            // クッキーをクライアント(ブラウザ)へ保存する
            $cookie = \Cookie::make('count', md5(uniqid(mt_rand(), true)), 1);



            return Response::view('ideaSubmitted')->withCookie($cookie);
        }

    }

}
