import React, { Component } from 'react';
import RankingApi from '../../js/ranking-api';
import RankingTypes from '../../js/ranking-types';
import RankingItem from './ranking-item.jsx';

export default class RankingBody extends Component {
    constructor(props) {
        super(props);

        this.item_per_page = 20;

        this.state = { ranking : undefined };

        props.store.on("update", () => this.updateRankingData());
    }

    async updateRankingData() {
        const response = await RankingApi.getRanking(this.props.store.type, this.item_per_page * (this.page - 1), this.item_per_page);
        const ranking_json = await response.json();

        this.setState({ ranking : ranking_json });
    }

    componentDidMount() {
        return this.updateRankingData();
    }

    /**
     * ランキングのテーブルを構築する
     * @returns {XML}
     * @private
     */
    _getRankingBody() {
        // TODO 期間ランキングのAPIが実装され次第このブロックを消すこと
        if (this.props.store.duration !== "total") {
            return <div>"※ 近日公開予定"</div>;
        }

        let ranking_items = [];

        if (this.state.ranking !== undefined) {
            ranking_items = this.state.ranking.ranks.map(player_rank =>
                <RankingItem playerRank={player_rank} key={`${player_rank.player.uuid}-${player_rank.type}`}/>
            );
        }

        // TODO ページ切り替えバーを追加する
        return (
            <div className="ranking-table">
                <table className="table table-striped table-hover">
                    <tbody>
                    {ranking_items}
                    </tbody>
                </table>
            </div>
        );
    }

    render() {
        return (
            <div>
                <h3>◇ {RankingTypes.resolveRaw(this.props.store.type)}ランキング</h3>
                {this._getRankingBody()}
            </div>
        );
    }
}
