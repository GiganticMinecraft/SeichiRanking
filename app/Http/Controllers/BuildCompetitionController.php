<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Models\FormModel;
use App\BuildCompetitionThemeDivision;
use App\BuildCompetitionApply;
use App\BuildCompetitionVote;

class BuildCompetitionController extends Controller
{
    protected $model;
    protected $jms_user_info;

    /**
     * BuildCompetitionController constructor.
     */
    public function __construct()
    {
    }

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
            ->select(
                'build_competition_apply_id',
                'build_competition_apply.mcid',
                'contact_means',
                'build_competition_apply.theme_division_id',
                'glyphicon',
                'theme_division_name',
                'apply_comment',
                'partition_no',
                'build_competition_vote_id',
                'build_competition_vote_apply_id'
            )
            ->join(
                'build_competition_theme_division',
                'build_competition_apply.theme_division_id',
                '=',
                'build_competition_theme_division.theme_division_id'
            )
            ->leftJoin('build_competition_vote', function ($join) {
                $join->on('build_competition_theme_division.theme_division_id', '=', 'build_competition_vote.theme_division_id')
                    ->where('build_competition_vote.uuid', '=', $this->jms_user_info['uuid']);
            })
            ->orderBy('build_competition_apply.theme_division_id')
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
        // 建築テーマの取得
        $themes = \DB::table('build_competition_theme_division')
            ->where('build_competition_group', config('buildcompetition.build_competition_count'))->get();

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
                'assetJs' => $assetJs,          // 独自定義JS
            ]
        );
    }

    public function applySubmit(Request $request)
    {
        // パラメータ取得
        $params = $request->all();
        \Log::debug('$params -> '.print_r($params, 1));

        // バリデーションチェック
        $this->validate($request, [
            'build_competition_group'    => 'required',
            'theme'  => 'required',
            'title' => 'required',
            'contact_id' => 'required',
            'reply_type' => 'required',
            'apply_comment' => 'required',
        ]);

        // 既存データチェック
        $apply_check = BuildCompetitionApply::where('uuid', $this->jms_user_info['uuid'])
            ->where('theme_division_id', $params['theme'])
            ->where('build_competition_group', $params['build_competition_group'])->first();

        // データがなければ投票
        if (count($apply_check) === 0){
            \DB::table('build_competition_apply')->insert([
                    'build_competition_group' => $params['build_competition_group'],
                    'theme_division_id' => $params['theme'],
                    'title' => $params['title'],
                    'apply_comment' => $params['apply_comment'],
                    'uuid' => $this->jms_user_info['uuid'],
                    'mcid' => $this->jms_user_info['preferred_username'],
                    'contact_means' => $params['reply_type'],
                    'contact_id' => $params['contact_id'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
        else {
            // テーマ名取得
            $theme = BuildCompetitionThemeDivision::where('theme_division_id', $params['theme'])->first();
            // 応募画面へ
            return redirect('/buildCompetition/apply')->with('message', $theme->theme_division_name.'は、既に応募済みです。');
        }

        // 完了画面へ遷移
        return redirect('/thanks')->with('message', '建築コンペのご応募、ありがとうございました。');
    }

    public function submit(Request $request)
    {
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
            return redirect('/thanks')->with('message', '建築コンペの投票、ありがとうございました。');
        }
    }

}
