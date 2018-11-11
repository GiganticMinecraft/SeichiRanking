<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Models\FormModel;
use App\BuildCompetitionThemeDivision;
use App\BuildCompetitionApply;
use App\BuildCompetitionVote;
use App\Rules\TwitterIdCheck;
use Validator;

class BuildCompetitionController extends Controller
{
    protected $model;
    protected $jms_user_info;

    public function index()
    {
        $this->model = new FormModel();

        try {
            // ユーザ情報を取得
            $this->jms_user_info = $this->model->jms_login_auth()->getUser();
        }
            // 未ログインの場合、例外としてキャッチする
        catch (\Exception $e) {
            // セッションに戻り先URLをセット
            session(['callback_url' => '/buildCompetition']);

            \Log::debug(print_r($e->getMessage(), 1));
            return redirect()->to('/login/jms');
        }

        // 応募者情報
        $apply_data = \DB::table('build_competition_apply')
            ->select([
                \DB::raw('build_competition_apply.id AS build_competition_apply_id'),
                'build_competition_apply.mcid',
                'contact_means',
                \DB::raw('build_competition_apply.id AS theme_division_id'),
                'glyphicon',
                'theme_division_name',
                'title',
                'apply_comment',
                'img_path',
                'partition_no',
                \DB::raw('build_competition_vote.id AS build_competition_vote_id'),
                'build_competition_vote_apply_id'
            ])
            ->join(
                'build_competition_theme_division',
                'build_competition_apply.theme_division_id',
                '=',
                'build_competition_theme_division.id'
            )
            ->leftJoin('build_competition_vote', function ($join) {
                $join->on('build_competition_theme_division.id', '=', 'build_competition_vote.theme_division_id')
                    ->where('build_competition_vote.uuid', '=', $this->jms_user_info['uuid']);
            })
            ->orderBy('build_competition_apply.theme_division_id')
            ->orderBy('partition_no')
            ->get();

        // 整形する
        $result = [];
        $vote_flg = false;
        foreach ($apply_data as $apply_datum) {
            $result[$apply_datum->theme_division_id]['theme_division_name'] = $apply_datum->theme_division_name;
            $result[$apply_datum->theme_division_id]['glyphicon'] = $apply_datum->glyphicon;
            $result[$apply_datum->theme_division_id]['apply_data'][] = $apply_datum;

            // 投票していないジャンルがあれば、投票可能フラグを立てる
            if (is_null($apply_datum->build_competition_vote_apply_id)) {
                $vote_flg = true;
            }
        }

        return view(
            'build_competition.index',
            [
                'user'       => $this->jms_user_info,
                'apply_data' => $result,
                'vote_flg'   => $vote_flg,
            ]
        );
    }

    public function apply(Request $request)
    {
        $this->model = new FormModel();

        try {
            // ユーザ情報を取得
            $this->jms_user_info = $this->model->jms_login_auth()->getUser();
        }
            // 未ログインの場合、例外としてキャッチする
        catch (\Exception $e) {
            // セッションに戻り先URLをセット
            session(['callback_url' => '/buildCompetition/apply']);

            \Log::debug(print_r($e->getMessage(), 1));
            return redirect()->to('/login/jms');
        }

        // 開催有無のチェック
        $presence = $this->checkPresence($request->get('id'));
        if (empty($presence)) {
            abort(404);
        }
        \Log::debug(print_r($presence, 1));

        // 建築テーマの取得
        $themes = \DB::table('build_competition_theme_division')
            ->where('build_competition_manage_id', $request->get('id'))->get();

        $my_apply_data = BuildCompetitionApply::where('uuid', $this->jms_user_info['uuid'])->get();


        // 独自定義JS
        $assetJs = [
            '/js/inquiry.js'
        ];

        return view(
            'build_competition.apply',
            [
                'user'          => $this->jms_user_info,
                'themes'        => $themes,
                'my_apply_data' => $my_apply_data,
                'manage_id'     => $request->get('id'),
                'presence'      => $presence,
                'assetJs'       => $assetJs,          // 独自定義JS
            ]
        );
    }

    public function applySubmit(Request $request)
    {
        $this->model = new FormModel();

        try {
            // ユーザ情報を取得
            $this->jms_user_info = $this->model->jms_login_auth()->getUser();
        }
            // 未ログインの場合、例外としてキャッチする
        catch (\Exception $e) {
            // セッションに戻り先URLをセット
            session(['callback_url' => '/buildCompetition']);

            \Log::debug(print_r($e->getMessage(), 1));
            return redirect()->to('/login/jms');
        }

        // パラメータ取得
        $params = $request->all();
        \Log::debug('$params -> '.print_r($params, 1));

        $validate_rule = [];

        // 返信タイプのセット
        if ($params['reply_type'] == 'twitter') {
            $contact_id_label = 'Twitter ID';

            $validate_rule = [
                'build_competition_manage_id'    => 'required',
                'theme'  => 'required',
                'title' => 'required',
                'reply_type'   => 'required|in:twitter,discord',
                'contact_id'   => ['required', new TwitterIdCheck],
                'apply_comment' => 'required',
                'img' => 'max:10240|mimes:jpeg,gif,png',
            ];
        }
        elseif ($params['reply_type'] == 'discord') {
            $contact_id_label = 'Discord ID';

            $validate_rule = [
                'build_competition_manage_id'    => 'required',
                'theme'  => 'required',
                'title' => 'required',
                'reply_type'   => 'required|in:twitter,discord',
                'contact_id'   => 'required',
                'apply_comment' => 'required',
                'img' => 'max:10240|mimes:jpeg,gif,png',
            ];
        }
        else {
            $contact_id_label = 'ID';
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

        // 既存データチェック
        $apply_check = BuildCompetitionApply::where('uuid', $this->jms_user_info['uuid'])
            ->where('id', $params['theme'])
            ->where('build_competition_manage_id', $params['build_competition_manage_id'])->first();

        // データがなければ応募
        if (count($apply_check) === 0){
            // 画像保存
            $path= '';
            if ($request->hasFile('img')) {
                $path = $request->file('img')->storeAs(
                    'build_competition/'.config('buildcompetition.build_competition_count').$this->jms_user_info['uuid'],
                    $request->file('img')->getClientOriginalName(),
                    'public'
                );
                \Log::debug(__LINE__.'$path ----> '.print_r($path, 1));
            }

            \DB::table('build_competition_apply')->insert([
                    'build_competition_manage_id' => $params['build_competition_manage_id'],
                    'theme_division_id' => $params['theme'],
                    'title' => $params['title'],
                    'apply_comment' => $params['apply_comment'],
                    'uuid' => $this->jms_user_info['uuid'],
                    'mcid' => $this->jms_user_info['preferred_username'],
                    'contact_means' => $params['reply_type'],
                    'contact_id' => $params['contact_id'],
                    'img_path' => $path,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );

        }
        else {
            // テーマ名取得
            $theme = BuildCompetitionThemeDivision::where('id', $params['theme'])->first();
            // 応募画面へ
            return redirect('/buildCompetition/apply')->with('message', $theme->theme_division_name.'は、既に応募済みです。');
        }

        // 完了画面へ遷移
        return redirect('/buildCompetition/thanks')
            ->with([
                'message'      => '建築コンペのご応募、ありがとうございました。',
                'redirect_url' => 'buildCompetition'
            ]);
    }

    public function submit(Request $request)
    {
        $this->model = new FormModel();

        try {
            // ユーザ情報を取得
            $this->jms_user_info = $this->model->jms_login_auth()->getUser();
        }
            // 未ログインの場合、例外としてキャッチする
        catch (\Exception $e) {
            // セッションに戻り先URLをセット
            session(['callback_url' => '/buildCompetition']);

            \Log::debug(print_r($e->getMessage(), 1));
            return redirect()->to('/login/jms');
        }

        // TODO: 全テーマ投票済みであれば、Indexに戻す
        if (false) {
        }
        // 投稿処理
        else {
            // パラメータ取得
            $params = $request->all();
            unset($params['_token']);
            \Log::debug('$params -> '.print_r($params, 1));

            // バリデーションチェック
//            $this->validate($request, [
//                'idea_text'    => 'required',
//                'idea_reason'  => 'required',
//                'idea_example' => 'required',
//            ]);

            foreach ($params as $theme_division_id => $build_competition_vote_apply_id) {

                // 既存データチェック
                $vote_check = BuildCompetitionVote::where('uuid', $this->jms_user_info['uuid'])
                    ->where('theme_division_id', $theme_division_id)->first();

                // データがなければ投票
                if (count($vote_check) === 0){
                    \DB::table('build_competition_vote')->insert([
                            'theme_division_id' => $theme_division_id,
                            'build_competition_vote_apply_id' => $build_competition_vote_apply_id,
                            'uuid' => $this->jms_user_info['uuid'],
                            'mcid' => $this->jms_user_info['preferred_username'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]
                    );
                }
            }

            // 投稿完了画面へ遷移
            return redirect('/buildCompetition/thanks')->with('message', '建築コンペの投票、ありがとうございました。');
        }
    }

    public function thanks()
    {
        return view('build_competition.thanks');
    }

    public function checkPresence($id)
    {
        return \DB::table('build_competition_manage')
            ->where('id', $id)
            ->first();
    }

}
