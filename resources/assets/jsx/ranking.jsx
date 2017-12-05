'use strict';

import "babel-polyfill";

import React from "react";
import ReactDOM from 'react-dom';

import RankingBody from "./components/ranking-body.jsx";
import RankingTypeNavigator from "./components/ranking-type-navigator.jsx"
import RankingDurationNavigator from "./components/ranking-duration-navigator.jsx";
import rankingStore from "../js/ranking-store";
import {observe} from "../../../node_modules/mobx/lib/mobx";

document.addEventListener("DOMContentLoaded", () => {
    ReactDOM.render(<RankingBody store={rankingStore}/>, document.getElementById('ranking-container'));
    ReactDOM.render(<RankingTypeNavigator/>, document.getElementById('ranking-type-nav'));
    ReactDOM.render(<RankingDurationNavigator/>, document.getElementById('ranking-duration-nav'));
});

//---------------------------
// ストアに対するリスナを追加

/**
 * 指定オブジェクトをアンカーの表示形式に変換する
 * @param obj
 * @return string
 */
const toAnchorString = (obj) => "#" + Object.keys(obj)
    .map(key => [key, obj[key]])
    .map(([key, val]) => `${key}=${val}`)
    .join("&");

observe(rankingStore, "ranking", _ => {
    // アンカーを変更する
    window.location.hash = toAnchorString({
        page : rankingStore.page,
        type : rankingStore.type,
        duration : rankingStore.duration
    });

    // ページ変更時にスクロールを巻き戻す
    window.scrollTo(0, 0);
});
