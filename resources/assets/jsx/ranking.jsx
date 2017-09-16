'use strict';

import React from "react";
import ReactDOM from 'react-dom';
import { RankingBody, RankingTypeNavigator } from "./ranking-components.jsx";

class RankingStore {
    static isDurationValid(duration) {
        return ["total", "daily", "weekly", "monthly"].includes(duration);
    }

    static isTypeValid(type) {
        return ["break", "build", "playtime", "vote"].includes(type);
    }

    constructor({duration, type, page}) {
        [this.duration, this.type, this.page] = [duration, type, page];

        // パラメータに不足又は異常があった場合デフォルト値を設定する
        this.page = Math.max(this.page || 1, 1);

        if (!RankingStore.isDurationValid(this.duration)) {
            this.duration = "total";
        }

        if (!RankingStore.isTypeValid(this.type) || (this.type === "vote" && this.duration === "daily")) {
            this.type = "break";
        }
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

    /**
     * ランキングページの構成に必要なパラメータをURLから取得する
     * @returns {{duration, type, page}}
     */
    function getRankingPageParams() {
        let {duration, type, page} = getQueryObject(window.location.hash);

        return {
            duration : duration,
            type : type,
            page : page
        }
    }

    function renderRanking(store) {
        ReactDOM.render(<RankingBody duration={store.duration} type={store.type} page={store.page}/>, document.getElementById('ranking-container'));
        ReactDOM.render(<RankingTypeNavigator duration={store.duration} type={store.type}/>, document.getElementById('ranking-type-nav'));
    }

    const rankingStore = new RankingStore(getRankingPageParams());
    renderRanking(rankingStore);
})();
