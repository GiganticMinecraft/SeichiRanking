import React from 'react';
import RankingTypes from '../../js/ranking-types';
import Pagination from "./pagination.jsx";

import { observer } from 'mobx-react'
import rankingStore from '../../js/ranking-store';

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

/**
 * アバターのURLを取得する
 * @param playerName プレーヤー名
 */
const getAvatarUrl = playerName => `https://avatar.minecraft.jp/${playerName}/minecraft//m.png`;

const RankingItem = observer(({rank: rankObject}) => {
    const player = rankObject.player;

    return (
        <tr>
            <th scope="row">
                <span className="rank">
                    {rankObject.rank}位
                </span>
            </th>
            <td>
                <div className="avatar-placeholder">
                    <img src={getAvatarUrl(player.name)} width="60px" height="60px"/>
                </div>
            </td>
            <td>
                {player.name}<br />
                <span className="ranked-data">
                        {RankingTypes.resolveRaw(rankObject.type)}：{formatRankedData(rankObject.data, rankObject.type)}
                </span><br />
                <span className="last_login">Last quit：{rankObject.lastquit}</span>
            </td>
        </tr>
    );
});

const WrappedPagination = observer(({ store }) =>
    store.ranking !== undefined
        ? <Pagination currentPage={store.page}
                      totalPages={Math.ceil(store.ranking.total_ranked_player / store.item_per_page)}
                      onPageChange={ page => store.setPage(page) }/>
        : null
);

const RankingTable = observer(({ store }) => {
    // TODO 期間ランキングのAPIが実装され次第このブロックを消すこと
    if (store.duration === "weekly" || store.duration === "monthly" || store.duration === "yearly") {
        return <div>※ 近日公開予定</div>;
    }

    if (store.ranking === undefined) {
        return null;
    }

    return (
        <div className="ranking-table">
            <table className="table table-striped table-hover">
                <tbody>
                {store.ranking.ranks.map(rank =>
                    <RankingItem rank={rank} key={`${rank.player.uuid}-${rank.type}`}/>
                )}
                </tbody>
            </table>
            <WrappedPagination store={store}/>
        </div>
    );
});

export default observer(({ store }) =>
    <div>
        <h3>◇ {RankingTypes.resolveRaw(rankingStore.type)}ランキング</h3>
        <RankingTable store={rankingStore} />
    </div>
);
