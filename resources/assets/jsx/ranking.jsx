'use strict';

import React from "react";
import ReactDOM from 'react-dom';
import { RankingBody, RankingTypeNavigator } from "./ranking-components.jsx";

import rankingStore from "../js/ranking-store";

(() => {
    function renderRanking(store) {
        ReactDOM.render(<RankingBody duration={store.duration} type={store.type} page={store.page}/>, document.getElementById('ranking-container'));
        ReactDOM.render(<RankingTypeNavigator duration={store.duration} type={store.type}/>, document.getElementById('ranking-type-nav'));
    }

    renderRanking(rankingStore);
})();
