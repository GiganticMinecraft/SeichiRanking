'use strict';

import React from "react";
import ReactDOM from 'react-dom';
import { RankingBody, RankingTypeNavigator } from "./ranking-components.jsx";
import rankingStore from "../js/ranking-store";

(() => {
    ReactDOM.render(<RankingBody store={rankingStore}/>, document.getElementById('ranking-container'));
    ReactDOM.render(<RankingTypeNavigator store={rankingStore}/>, document.getElementById('ranking-type-nav'));
})();
