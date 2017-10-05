<?php

namespace App\Http\Models\Api;

use App\Http\Models\Api\PlayerData\BreakPlayerDataResolver;
use App\Http\Models\Api\PlayerData\BuildPlayerDataResolver;
use App\Http\Models\Api\PlayerData\LastQuitPlayerDataResolver;
use App\Http\Models\Api\PlayerData\PlayerDataResolver;
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
     * 指定モードが有効かどうかの真偽値を返します
     * @param $mode string モードの文字列
     * @return bool
     */
    public function isValidMode($mode)
    {
        return isset($this->resolvers[$mode]);
    }

    /**
     * 指定モードに対応するリゾルバのインスタンスを返します
     * @param $mode string モードの文字列
     * @return PlayerDataResolver
     */
    public function getResolver($mode)
    {
        return $this->resolvers[$mode];
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