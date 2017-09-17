import React, { Component } from 'react';
import RankingDuration from '../../js/ranking-durations'

export default class RankingDurationNavigator extends Component {
    constructor(props) {
        super(props);

        this._getTab = this._getTab.bind(this);
    }

    _getTab(duration) {
        return (
            <li>
                <a key={duration} onClick={() => this.props.store.setDuration(duration)}>
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
