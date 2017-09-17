import { EventEmitter2 } from "eventemitter2";
import RankingTypes from "./ranking-types";

class RankingStore extends EventEmitter2 {
    static isDurationValid(duration) {
        return ["total", "daily", "weekly", "monthly"].includes(duration);
    }

    static isTypeValid(type) {
        return ["break", "build", "playtime", "vote"].includes(type);
    }

    /**
     * 与えられたパラメータに不整合がないようにして配列形式で返す
     *
     * @returns {[string,string,int]} [duration, type, page] の形式で返却される
     * 戻り値は整えられているのでページレンダリングにそのまま使用してよい
     */
    static constructParameters({duration : _duration, type : _type, page : _page}) {
        let {duration, type, page} = [_duration, _type, _page];

        page = Math.max(page || 1, 1);

        if (!RankingStore.isDurationValid(duration)) {
            duration = "total";
        }

        if (!RankingStore.isTypeValid(type) || (type === "vote" && duration === "daily")) {
            type = "break";
        }

        return [duration, type, page];
    }

    constructor(parameterObject) {
        super();
        EventEmitter2.call(this);

        [this.duration, this.type, this.page] = RankingStore.constructParameters(parameterObject);
    }

    _emitUpdateEvent(updateComponent) {
        this.emit("update", this, updateComponent);
    }

    /**
     * pageパラメータを更新する
     * @param page
     */
    setPage(page){
        const oldPage = this.page;
        this.page = page;

        // 更新処理
        if (oldPage !== page) {
            this._emitUpdateEvent("page");
        }
    }

    /**
     * typeパラメータを更新する
     * @param type
     */
    setType(type) {
        if (!RankingStore.isTypeValid(type)) {
            throw new Error("Given type is invalid");
        }

        const oldType = this.type;
        this.type = type;

        // 更新処理
        if (oldType !== type) {
            this.page = 1;
            this._emitUpdateEvent("type")
        }
    }

    setDuration(duration) {
        if (!RankingStore.isDurationValid(duration)) {
            throw new Error("Given duration is invalid");
        }

        const oldDuration = this.duration;
        this.duration = duration;

        // durationとtypeが矛盾していれば、typeをbreakにする
        if (!RankingTypes.getAvailableTypes(duration).includes(this.type)) {
            this.type = "break";
        }

        // 更新処理
        if (oldDuration !== duration) {
            this.page = 1;
            this._emitUpdateEvent("duration");
        }
    }
}

/**
 * ハッシュ以降のクエリをオブジェクトとして取得する
 * @param hash
 * @returns {*}
 */
function getQueryObject(hash) {
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

/**
 * ランキングページの構成に必要なパラメータをURLから取得する
 * @returns {{duration, type, page}}
 */
function getRankingPageParams() {
    let {duration, type, page} = getQueryObject(window.location.hash);

    return {
        duration : duration,
        type : type,
        page : page
    }
}

export default new RankingStore(getRankingPageParams());