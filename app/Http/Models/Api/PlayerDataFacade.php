<?php

namespace App\Http\Models\Api;

use App\Http\Models\Api\PlayerData\BreakPlayerDataResolver;
use App\Http\Models\Api\PlayerData\BuildPlayerDataResolver;
use App\Http\Models\Api\PlayerData\LastQuitPlayerDataResolver;
use App\Http\Models\Api\PlayerData\PlaytimePlayerDataResolver;
use App\Http\Models\Api\PlayerData\VotePlayerDataResolver;

class PlayerDataFacade
{
    private $resolvers;
    private function __construct()
    {
        $this->resolvers = [
            "break" => new BreakPlayerDataResolver(),
            "build" => new BuildPlayerDataResolver(),
            "playtime" => new PlaytimePlayerDataResolver(),
            "vote" => new VotePlayerDataResolver(),
            "lastquit" => new LastQuitPlayerDataResolver()
        ];
    }

    /**
     * 指定データタイプが有効かどうかの真偽値を返します
     * @param $mode string データタイプ文字列
     * @return bool
     */
    public function isValidMode($mode)
    {
        return isset($this->resolvers[$mode]);
    }

    /**
     * 指定プレーヤーの指定データを取得します。
     * データタイプが無効の場合例外が発生するので、事前に{@see isValidMode}で有効性をチェックして下さい。
     * @param $mode string データタイプ文字列
     * @param $player_uuid string プレーヤーのuuid
     * @return array
     */
    public function resolveData($mode, $player_uuid)
    {
        return $this->resolvers[$mode]->resolveData($player_uuid);
    }

    private static $instance;

    /**
     * シングルトンのインスタンスを取得します
     * @return PlayerDataFacade
     */
    public static function getInstance()
    {
        if (!isset(PlayerDataFacade::$instance)) {
            PlayerDataFacade::$instance = new PlayerDataFacade();
        }

        return PlayerDataFacade::$instance;
    }
}