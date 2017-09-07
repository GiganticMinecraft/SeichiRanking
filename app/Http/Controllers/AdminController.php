<?php

namespace App\Http\Controllers;

use App\Http\Models\AdminModel;
use App\Http\Models\FormModel;
use Illuminate\Http\Request;
use Log;
use Auth;
use Mockery\Exception;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->model = new AdminModel();
    }

    /**
     * 管理者ページTOP
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // 未ログイン時は、ログインページへリダイレクト
        if (!Auth::check()) {
            return redirect()->to('/admin/login');
        }
        Log::debug('管理者TOP');

        return view('admin/home');
    }

    /**
     * お問い合わせ一覧
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function inquiry(Request $request)
    {
        // 未ログイン時は、ログインページへリダイレクト
        if (!Auth::check()) {
            return redirect()->to('/admin/login');
        }

        // 問い合わせ一覧を取得
        $inquiry_list = $this->model->get_inquiry_list($request);

        return view('admin/inquiry',['inquiry_list' => $inquiry_list]);
    }

    /**
     * お問い合わせ詳細
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function inquiry_detail(Request $request)
    {
        // 未ログイン時は、ログインページへリダイレクト
        if (!Auth::check()) {
            return redirect()->to('/admin/login');
        }

        // お問い合わせの詳細データを取得
        $inquiry_detail = $this->model->get_inquiry_detail($request);

        return view('admin/inquiry_detail', ['inquiry_detail' => $inquiry_detail]);

    }

    /**
     * 回答データ保存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function inquiry_submit(Request $request)
    {
        Log::debug('$request -> '.print_r($request->input(), 1));

        try {
            // 回答データ保存
            $this->model->save_inquiry_answer($request);

            // 問い合わせ一覧画面へ遷移
            $message = '【No:'.$request->input('inquiry_id').'】'.$request->input('name').'さんへの回答を送信しました。';
            return redirect('/admin/inquiry')->with('message', $message);
        }
        catch (Exception $e) {
            Log::error($e->getMessage());
            // 問い合わせ一覧画面へ遷移
            return redirect('/admin/inquiry')->with('error', '回答データの送信に失敗しました。');
        }

    }

    /**
     * アカウント管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function account()
    {
        // 未ログイン時は、ログインページへリダイレクト
        if (!Auth::check()) {
            return redirect()->to('/admin/login');
        }

        // アカウント一覧を取得
        $account_list = $this->model->get_account_list();

        return view('admin/account',['account_list' => $account_list]);
    }

    /**
     * ログイン
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->to('/admin/');
        }

        return view('auth/adminLogin');
    }

    /**
     * ログアウト
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect()->to('/admin/');
    }

    /**
     * ログイン有無によって、ログイン画面へリダイレクトする
     * @return \Illuminate\Http\RedirectResponse
     */
    public function auth_check()
    {
        if (!Auth::check()) {
            return redirect()->to('/admin/login');
        }
    }
}
