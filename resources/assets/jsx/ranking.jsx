'use strict';

import React from "react";
import ReactDOM from 'react-dom';
import RankingBody from "./ranking-components.jsx";

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
        ReactDOM.render(<RankingBody duration={duration} type={type} page={page}/>, document.getElementById('ranking-container'));
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
