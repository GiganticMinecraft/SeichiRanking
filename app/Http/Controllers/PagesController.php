<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function __construct()
    {
        // サーバーステータスの取得
        $this->server_status = $this->get_server_status();
    }

    /**
     * このページについて
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        return view('pages.about', [
            'server_status' => $this->server_status,
        ]);
    }

    /**
     * お問い合わせ
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        return view('pages.contact', [
            'server_status' => $this->server_status,
        ]);
    }

    public function thanks()
    {
        // フォームの各投稿完了画面を表示
        return view('ideaSubmitted');
    }
}
