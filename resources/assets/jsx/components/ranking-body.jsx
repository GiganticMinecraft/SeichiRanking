import React, { Component } from 'react';
import RankingTypes from '../../js/ranking-types';
import RankingItem from './ranking-item.jsx';
import Pagination from "./pagination.jsx";

import { observer } from 'mobx-react'
import rankingStore from '../../js/ranking-store';

@observer
export default class RankingBody extends Component {
    constructor(props) {
        super(props);

        this.item_per_page = 20;
    }

    /**
     * ランキングのテーブルを構築する
     * @returns {XML}
     * @private
     */
    _getRankingBody() {
        // TODO 期間ランキングのAPIが実装され次第このブロックを消すこと
        if (rankingStore.duration !== "total") {
            return <div>"※ 近日公開予定"</div>;
        }

        let ranking_items = [];

        if (rankingStore.ranking !== undefined) {
            ranking_items = rankingStore.ranking.ranks.map(player_rank =>
                <RankingItem playerRank={player_rank} key={`${player_rank.player.uuid}-${player_rank.type}`}/>
            );
        }

        return (
            <div className="ranking-table">
                <table className="table table-striped table-hover">
                    <tbody>
                    {ranking_items}
                    </tbody>
                </table>
                {this._getPagination()}
            </div>
        );
    }

    _getPagination() {
        if (rankingStore.ranking === undefined) {
            return null;
        }

        const total_pages = Math.ceil(rankingStore.ranking.total_ranked_player / this.item_per_page);
        return <Pagination currentPage={rankingStore.page}
                           totalPages={total_pages}
                           onPageChange={ page => rankingStore.setPage(page) }/>
    }

    render() {
        return (
            <div>
                <h3>◇ {RankingTypes.resolveRaw(rankingStore.type)}ランキング</h3>
                {this._getRankingBody()}
            </div>
        );
    }
}
