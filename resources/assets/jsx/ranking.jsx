'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import RankingApi from '../js/ranking-api';

class RankingItem extends Component {
    constructor(props) {
        super(props);
        const player_rank = this.props.playerRank;

        this.player = player_rank.player;
        this.type = player_rank.type;
        this.rank = player_rank.rank;
        this.avatar_url = `https://mcapi.ca/avatar/${this.player.name}/60`;

        this.state = {
            ranked_data : "",
            last_quit : ""
        };
    }

    render() {
        return (
            <tr>
                <th scope="row">
                    <span className="rank">
                        {this.rank} 位
                    </span>
                </th>
                <td>
                    <img src={this.avatar_url}/>
                </td>
                <td>
                    {this.player.name}<br />
                    <span className="ranked-data">整地量：{this.state.ranked_data || ""}</span><br />
                    <span className="last_login">Last quit：{this.state.last_quit || ""}</span>
                </td>
            </tr>
        );
    }
}

class Ranking extends Component {
    constructor(props) {
        super(props);

        this.item_per_page = 20;

        this.page = props.page || 1;
        this.duration = props.duration || "total";
        this.type = props.type || "break";

        this.state = {
            ranking : undefined
        };
    }

    setStateAsync(state) {
        return new Promise(res => this.setState(state, res));
    }

    async componentDidMount() {
        const response = await RankingApi.getRanking(this.type, this.item_per_page * (this.page - 1) + 1, this.item_per_page);

        await this.setStateAsync({
            "ranking" : await response.json()
        });
    }

    /**
     * ランキングのテーブルを構築する
     * @returns {XML}
     * @private
     */
    _getRankingBody() {
        if (duration !== "total") {
            return <div>"※ 近日公開予定"</div>;
        }

        let ranking_items = [];

        if (this.state.ranking !== undefined) {
            ranking_items = this.state.ranking.ranks.map(player_rank =>
                <RankingItem playerRank={player_rank} key={`${player_rank.player.uuid}-${player_rank.type}`}/>
            );
        }

        // TODO ページ切り替えバーを追加
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
                <h3>◇ 整地量ランキング</h3>
                {this._getRankingBody()}
            </div>
        );
    }
}

ReactDOM.render(<Ranking duration={duration} type={type} page={1}/>, document.getElementById('ranking-container'));
