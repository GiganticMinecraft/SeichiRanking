import React, { Component } from 'react';
import RankingDuration from '../../js/ranking-durations'
import rankingStore from '../../js/ranking-store';
import {observer} from "mobx-react";

@observer
export default class RankingDurationNavigator extends Component {
    constructor(...args) {
        super(...args);

        this._getTab = this._getTab.bind(this);
    }

    _getTab(duration) {
        const isActive = duration === rankingStore.duration;
        return (
            <li className={isActive ? "active" : "clickable"} key={`${duration}${isActive ? "-active" : ""}`}>
                <a onClick={() => rankingStore.setDuration(duration)}>
                    {RankingDuration.resolveRaw(duration)}
                </a>
            </li>
        );
    }

    render() {
        return (
            <ul className="nav navbar-nav">
                { RankingDuration.getAvailableDurations().map(this._getTab) }
            </ul>
        );
    }
}
