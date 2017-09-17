'use strict';

import React from "react";
import ReactDOM from 'react-dom';

import RankingBody from "./components/ranking-body.jsx";
import RankingTypeNavigator from "./components/ranking-type-navigator.jsx"
import RankingDurationNavigator from "./components/ranking-duration-navigator.jsx";

import rankingStore from "../js/ranking-store";

ReactDOM.render(<RankingBody store={rankingStore}/>, document.getElementById('ranking-container'));
ReactDOM.render(<RankingTypeNavigator store={rankingStore}/>, document.getElementById('ranking-type-nav'));
ReactDOM.render(<RankingDurationNavigator store={rankingStore}/>, document.getElementById('ranking-duration-nav'));
