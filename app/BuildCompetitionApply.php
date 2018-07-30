<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildCompetitionApply extends Model
{

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'build_competition_apply';

    /**
     * ユーザーに関連する電話レコードを取得
     */
    public function divisionName()
    {
        return $this->hasOne('App\BuildCompetitionThemeDivision');
    }
}
