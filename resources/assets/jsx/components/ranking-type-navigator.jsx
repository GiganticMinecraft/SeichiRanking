import React, {Component} from 'react';
import RankingTypes from '../../js/ranking-types';
import rankingStore from '../../js/ranking-store'
import {observer} from "mobx-react";

@observer
export default class RankingTypeNavigator extends Component {
    constructor(props) {
        super(props);

        this._getTab = this._getTab.bind(this);
    }

    _getTab(type) {
        let item_class_name = "clickable nav-item ranking-type-item";
        if (rankingStore.type === type) {
            item_class_name += " active";
        }

        let tab_title = RankingTypes.resolveRaw(type);

        // 長さが不足していれば空白を挿入する
        if (tab_title.length < 4) {
            tab_title = tab_title.split("").join(" ");
        }

        return (
            <li className={item_class_name} key={type}>
                <a className="nav-link bg-primary" data-toggle="tab" onClick={ () => rankingStore.setType(type) }>{tab_title}</a>
            </li>
        );
    }

    render() {
        return (
            <ul className="nav nav-tabs">
                { RankingTypes.getAvailableTypes(rankingStore.duration).map(this._getTab) }
            </ul>
        );
    }
}
