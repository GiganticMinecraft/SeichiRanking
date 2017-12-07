import React, {Component} from 'react';
import RankingTypes from '../../js/ranking-types';
import rankingStore from '../../js/ranking-store'
import {observer} from "mobx-react";

class RankingTypeTab extends Component {
    render() {
        const tab_type = this.props.type;

        let tab_classes = "clickable nav-item ranking-type-item";
        if (rankingStore.type === tab_type) {
            tab_classes += " active";
        }

        let tab_title = RankingTypes.resolveRaw(tab_type);

        // 長さが不足していれば空白を挿入する
        if (tab_title.length < 4) {
            tab_title = tab_title.split("").join(" ");
        }

        return (
            <li className={tab_classes}>
                <a className="nav-link bg-primary" data-toggle="tab" onClick={ () => rankingStore.setType(tab_type) }>{tab_title}</a>
            </li>
        );
    }
}

@observer
export default class RankingTypeNavigator extends Component {
    render() {
        return (
            <ul className="nav nav-tabs">
                { RankingTypes.getAvailableTypes(rankingStore.duration).map(
                    type => <RankingTypeTab type={type} key={type}/>
                ) }
            </ul>
        );
    }
}
