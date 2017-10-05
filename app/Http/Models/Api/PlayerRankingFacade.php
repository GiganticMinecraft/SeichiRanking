<?php

namespace App\Http\Models\Api;

use App\Http\Models\Api\PlayerRanking\BreakRankingResolver;
use App\Http\Models\Api\PlayerRanking\BuildRankingResolver;
use App\Http\Models\Api\PlayerRanking\PlaytimeRankingResolver;
use App\Http\Models\Api\PlayerRanking\RankingResolver;
use App\Http\Models\Api\PlayerRanking\VoteRankingResolver;

class PlayerRankingFacade
{
    private $resolvers;
    private function __construct()
    {
        $this->resolvers = [
            "break" => new BreakRankingResolver(),
            "build" => new BuildRankingResolver(),
            "playtime" => new PlaytimeRankingResolver(),
            "vote" => new VoteRankingResolver()
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
     * @return RankingResolver
     */
    public function getResolver($mode)
    {
        return $this->resolvers[$mode];
    }

    private static $instance;

    /**
     * シングルトンのインスタンスを取得します
     * @return PlayerRankingFacade
     */
    public static function getInstance()
    {
        if (!isset(PlayerRankingFacade::$instance)) {
            PlayerRankingFacade::$instance = new PlayerRankingFacade();
        }

        return PlayerRankingFacade::$instance;
    }

}