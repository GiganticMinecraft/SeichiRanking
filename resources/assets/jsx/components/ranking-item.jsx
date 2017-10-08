import React from 'react';
import RankingTypes from '../../js/ranking-types';
import {observer} from "mobx-react";


/**
 * プレーヤーデータAPIの戻り値を表示できる形式に変換する
 * @param json_data APIの戻り値
 * @param rankingType string ランキングの種類
 * @returns string
 */
const formatRankedData = (json_data, rankingType) => {
    if (rankingType === "playtime") {
        const {data} = json_data;
        return `${data.hours}時間${data.minutes}分${data.seconds}秒`;
    }

    // 生のデータを下から3桁ずつカンマで区切っていく
    const data = json_data["raw_data"];
    let result = "";
    for(let backward_index = 1; backward_index <= data.length; backward_index++) {
        const index = data.length - backward_index;
        result = data[index] + result;
        if (index !== 0 && backward_index % 3 === 0) {
            result = "," + result;
        }
    }

    return result;
};

const getAvatarUrl = playerName => `https://mcapi.ca/avatar/${playerName}/60`;

export default observer(({rank}) => {
    const player = rank.player;

    return (
        <tr>
            <th scope="row">
                <span className="rank">
                    {rank.rank}位
                </span>
            </th>
            <td>
                <img src={getAvatarUrl(player.name)}/>
            </td>
            <td>
                {player.name}<br />
                <span className="ranked-data">
                        {RankingTypes.resolveRaw(rank.type)}：{formatRankedData(rank.data, rank.type)}
                </span><br />
                <span className="last_login">Last quit：{rank.lastquit}</span>
            </td>
        </tr>
    );
});
