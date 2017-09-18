import React, { Component } from 'react';
import RankingTypes from '../../js/ranking-types';
import RankingApi from '../../js/ranking-api';

export default class RankingItem extends Component {
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

    /**
     * プレーヤーデータAPIの戻り値を表示できる形式に変換する
     * @param json_data APIの戻り値
     * @returns string
     * @private
     */
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
        const [ranked_data_json, last_quit_raw] = await Promise.all([
            RankingApi.getPlayerData(this.player.uuid, this.type).then(r => r.json()),
            RankingApi.getPlayerData(this.player.uuid, "lastquit").then(r => r.json()).then(r => r.raw_data)
        ]);
        const formatted_data = this._formatRankedData(ranked_data_json);

        this.setState({
            "ranked_data" : formatted_data,
            "last_quit" : last_quit_raw
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
                    <span className="ranked-data">
                        {RankingTypes.resolveRaw(this.type)}：{this.state.ranked_data || ""}
                    </span><br />
                    <span className="last_login">Last quit：{this.state.last_quit || ""}</span>
                </td>
            </tr>
        );
    }
}
