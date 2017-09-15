'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import RankingApi from '../js/ranking-api';

class RankingTypes {
    static get TYPE_MAP () {
        return {
            "break": "整地量",
            "build": "建築量",
            "playtime": "接続時間",
            "vote": "投票数"
        };
    }

    /**
     * ランキングタイプを日本語に解決する
     * @param type
     * @returns string
     */
    static resolveRaw(type) {
        return RankingTypes.TYPE_MAP[type];
    }

    /**
     * 期間パラメータに対して有効な型の配列を返す
     * @param duration
     * @returns {[string]}
     */
    static getAvailableTypes(duration) {
        const types = ["break", "build", "playtime"];
        if (duration === "daily") {
            return types;
        }
        types.push("vote");
        return types;
    }
}

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
                    <span className="ranked-data">
                        {RankingTypes.resolveRaw(this.type)}：{this.state.ranked_data || ""}
                    </span><br />
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
        const response = await RankingApi.getRanking(this.type, this.item_per_page * (this.page - 1), this.item_per_page);

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
        // TODO 期間ランキングのAPIが実装され次第このブロックを消すこと
        if (this.duration !== "total") {
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
                <h3>◇ {RankingTypes.resolveRaw(this.type)}ランキング</h3>
                {this._getRankingBody()}
            </div>
        );
    }
}

(() => {
    /**
     * ハッシュ以降のクエリをオブジェクトとして取得する
     * @param hash
     * @returns {*}
     */
    function getQueryObject(hash) {
        return hash.substring(1)
            .split("&")
            .map(param => {
                const [key, value] = param.split("=");
                const parameter_obj = {};
                parameter_obj[key] = value;

                return parameter_obj;
            })
            .reduce((previous, current) => Object.assign(previous, current));
    }

    const valid_durations = ["total", "daily", "weekly", "monthly"];
    const valid_types = ["break", "build", "playtime", "vote"];
    /**
     * ランキングページの構成に必要なパラメータをURLから取得する
     * @returns {{duration, type, page}}
     */
    function getRankingPageParams() {
        let {duration, type, page} = getQueryObject(window.location.hash);

        // パラメータに不足又は異常があった場合デフォルト値を設定する
        page = Math.max(page || 1, 1);

        if (!valid_durations.includes(duration)) {
            duration = "total";
        }

        if (!valid_types.includes(type) || (type === "vote" && duration === "daily")) {
            type = "break";
        }

        return {
            duration : duration,
            type : type,
            page : page
        }
    }

    function renderRanking(duration, type, page) {
        ReactDOM.render(<Ranking duration={duration} type={type} page={page}/>, document.getElementById('ranking-container'));
    }

    const {duration, type, page} = getRankingPageParams();
    renderRanking(duration, type, page);

    // ランキングタイプのタブを選択状態にする
    const target_tab = Array.prototype.find.call(
        document.getElementsByClassName("ranking-type-item"),
        tab => tab.getAttribute("data-ranking-type") === type
    );
    target_tab.classList.add("active");
})();
