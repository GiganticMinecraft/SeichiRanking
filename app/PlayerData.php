<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerData extends Model
{
    protected $table = 'playerdata';

    // 主キーの設定
    protected $primaryKey = ['name', 'uuid'];

    // increment無効化
    public $incrementing = false;

    // タイムスタンプの更新を無効か
    public $timestamps = false;
}
