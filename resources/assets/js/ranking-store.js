import RankingTypes from "./ranking-types";
import RankingDuration from "./ranking-durations";
import RankingApi from './ranking-api';
import {action, observable} from 'mobx';

class RankingStore {
    @observable duration;
    @observable type;
    @observable page;
    @observable ranking;
    @observable item_per_page;

    /**
     * 与えられたパラメータに不整合がないようにして配列形式で返す
     *
     * @returns {[string,string,int]} [duration, type, page] の形式で返却される
     * 戻り値は整えられているのでページレンダリングにそのまま使用してよい
     */
    static constructParameters({duration : _duration, type : _type, page : _page}) {
        let [duration, type, page] = [_duration, _type, _page];

        page = Math.max(page || 1, 1);

        if (!RankingDuration.getAvailableDurations().includes(duration)) {
            duration = "total";
        }

        if (!RankingTypes.getAvailableTypes(duration).includes(type)) {
            type = "break";
        }

        return [duration, type, page];
    }

    constructor() {
        this.ranking = undefined;
        this.item_per_page = 20;

        this.matchStateToUrl();
    }

    /**
     * ランキング情報をStoreのほかのデータを用いて更新する
     * @returns {Promise.<void>}
     * @private
     */
    @action async _updateRankingData() {
        const ranking_offset = this.item_per_page * (this.page - 1);
        const response = await RankingApi.getRanking(this.type, ranking_offset, this.item_per_page, this.duration);
        this.ranking = await response.json();
    }

    /**
     * pageパラメータを更新する
     * @param page
     */
    @action setPage(page){
        this.page = page;

        this._updateRankingData();
    }

    /**
     * typeパラメータを更新する
     * @param type
     */
    @action setType(type) {
        if (!RankingTypes.getAvailableTypes(this.duration).includes(type)) {
            throw new Error("Given type is invalid");
        }

        // typeが違うものに設定された場合、pageを1に戻す
        if (this.type !== type) {
            this.page = 1;
        }

        this.type = type;

        this._updateRankingData();
    }

    /**
     * durationパラメータを更新する
     * @param duration
     */
    @action setDuration(duration) {
        if (!RankingDuration.getAvailableDurations().includes(duration)) {
            throw new Error("Given duration is invalid");
        }

        this.duration = duration;

        // durationとtypeが矛盾していれば、typeをbreakにする
        if (!RankingTypes.getAvailableTypes(duration).includes(this.type)) {
            this.type = "break";
        }

        this._updateRankingData();
    }

    /**
     * ストアの状態をURLのハッシュに基づいて再セットする
     */
    @action matchStateToUrl() {
        const [duration, type, page] = RankingStore.constructParameters(getQueryObject(window.location.hash));
        const parameterObject = {duration, type, page};

        // 差分がある最初のパラメータを取得
        const updated_parameter = Object.entries(parameterObject).find(([key, value]) => this[key] !== value);

        // ストアの状態とURLに違いがあれば更新処理を行う
        if (updated_parameter !== undefined) {
            [this.duration, this.type, this.page] = [duration, type, page];
            this._updateRankingData();
        }
    }
}

/**
 * ハッシュ以降のクエリをオブジェクトとして取得する
 * @param hash
 * @returns {*}
 */
function getQueryObject(hash) {
    if (hash === "") {
        return ({});
    }

    return hash.substring(1)
        .split("&")
        .map(param => {
            const [key, value] = param.split("=");
            const parameter_obj = {};
            parameter_obj[key] = value;

            return parameter_obj;
        })
        .reduce((previous, current) => Object.assign(previous, current));
}

export default new RankingStore();