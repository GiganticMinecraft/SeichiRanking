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

    _formatRankedData(json_data) {
        if (this.type === "playtime") {
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
    }

    async componentDidMount() {
        const ranked_data_json = await RankingApi.getPlayerData(this.player.uuid, this.type).then(r => r.json());
        const formatted_data = this._formatRankedData(ranked_data_json);

        this.setState({
            "ranked_data" : formatted_data
        });
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

    async componentDidMount() {
        const response = await RankingApi.getRanking(this.type, this.item_per_page * (this.page - 1) + 1, this.item_per_page);

        this.setState({
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
