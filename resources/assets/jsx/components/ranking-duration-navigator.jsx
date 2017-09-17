import React, { Component } from 'react';
import RankingDuration from '../../js/ranking-durations'

export default class RankingDurationNavigator extends Component {
    constructor(props) {
        super(props);

        props.store.on("update", (_, updateParameter) => {
            // durationが変更されない限りnavvarへの変更も存在しない
            if (updateParameter !== "duration") {
                return;
            }

            this.forceUpdate();
        });

        this._getTab = this._getTab.bind(this);
    }

    _getTab(duration) {
        const isActive = duration === this.props.store.duration;
        return (
            <li className={isActive ? "active" : ""} key={`${duration}${isActive ? "-active" : ""}`}>
                <a onClick={() => this.props.store.setDuration(duration)}>
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
