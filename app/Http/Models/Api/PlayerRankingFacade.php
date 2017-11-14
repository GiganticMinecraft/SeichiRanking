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
     * 指定モードのランキングを取得します。
     * データタイプが無効の場合例外が発生するので、事前に{@see isValidMode}で有効性をチェックして下さい。
     * @param $mode string ランキングタイプ文字列
     * @param $offset integer オフセットの大きさ
     * @param $limit integer 取得するランキングのサイズ
     * @return mixed
     */
     public function getRanking($mode, $offset, $limit)
     {
        return $this->resolvers[$mode]->getRanking($offset, $limit);
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

    /**
     * 指定モードのランキングでのプレーヤー総数を返します。
     * データタイプが無効の場合例外が発生するので、事前に{@see isValidMode}で有効性をチェックして下さい。
     * @param $mode string ランキングタイプ文字列
     * @return integer
     */
    public function getRankedPlayerCount($mode)
    {
        return $this->resolvers[$mode]->getPlayerCount();
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