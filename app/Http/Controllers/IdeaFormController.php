<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Cookie;
use Log;

class IdeaFormController extends Controller
{
    /**
     * アイデア投稿フォームindex
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $message = null;

        return view(
            'ideaForm', [
                'message' => $message,
            ]
        );

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
            return redirect('ideaForm')->with('message', "アイディアの連続投稿はご遠慮ください。\nしばらく時間を置いてから投稿をお願いします。");
        }
        else {
            //
            $cookie = \Cookie::make('count', md5(uniqid(mt_rand(), true)), 1);
            return Response::view('IdeaSubmitted')->withCookie($cookie);
        }

    }

}
