<?php

namespace App\Http\Models\Api;

use App\Http\Models\Api\PlayerRanking\BreakRankingResolver;
use App\Http\Models\Api\PlayerRanking\BuildRankingResolver;
use App\Http\Models\Api\PlayerRanking\PlaytimeRankingResolver;
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
     * 指定モードのランキング全体を取得します。
     * データタイプが無効の場合例外が発生するので、事前に{@see isValidMode}で有効性をチェックして下さい。
     * @param $mode string データタイプ文字列
     * @return array
     */
    public function getRanking($mode)
    {
        return $this->resolvers[$mode]->getRanking();
    }

    /**
     * プレーヤーの順位を取得します。
     * データタイプが無効の場合例外が発生するので、事前に{@see isValidMode}で有効性をチェックして下さい。
     * @param $mode string データタイプ文字列
     * @param $player_uuid string プレーヤーのuuid
     * @return array
     */
    public function getPlayerRank($mode, $player_uuid)
    {
        return $this->resolvers[$mode]->getPlayerRank($player_uuid);
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