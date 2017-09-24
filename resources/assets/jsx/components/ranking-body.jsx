import React, { Component } from 'react';
import RankingTypes from '../../js/ranking-types';
import RankingItem from './ranking-item.jsx';
import Pagination from "./pagination.jsx";

import { observer } from 'mobx-react'
import rankingStore from '../../js/ranking-store';

const WrappedPagination = observer(({ store }) =>
    store.ranking !== undefined
        ? <Pagination currentPage={store.page}
                      totalPages={Math.ceil(store.ranking.total_ranked_player / store.item_per_page)}
                      onPageChange={ page => store.setPage(page) }/>
        : null
);


const RankingTable = observer(({ store }) => {
    console.log("rendered", store);

    // TODO 期間ランキングのAPIが実装され次第このブロックを消すこと
    if (store.duration !== "total") {
        return <div>"※ 近日公開予定"</div>;
    }

    if (store.ranking === undefined) {
        return null;
    }

    return (
        <div className="ranking-table">
            <table className="table table-striped table-hover">
                <tbody>
                {store.ranking.ranks.map(player_rank =>
                    <RankingItem playerRank={player_rank} key={`${player_rank.player.uuid}-${player_rank.type}`}/>
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
