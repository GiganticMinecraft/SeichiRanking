'use strict';

import React from "react";
import ReactDOM from 'react-dom';

import RankingBody from "./components/ranking-body.jsx";
import RankingTypeNavigator from "./components/ranking-type-navigator.jsx"
import RankingDurationNavigator from "./components/ranking-duration-navigator.jsx";

ReactDOM.render(<RankingBody/>, document.getElementById('ranking-container'));
ReactDOM.render(<RankingTypeNavigator/>, document.getElementById('ranking-type-nav'));
ReactDOM.render(<RankingDurationNavigator/>, document.getElementById('ranking-duration-nav'));
