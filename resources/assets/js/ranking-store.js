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

    _emitUpdateEvent() {
        this.emit("update", this);
    }

    /**
     * pageパラメータを更新する
     * @param page
     */
    setPage(page) {
        this.page = page;
        this._emitUpdateEvent();
    }

    /**
     * typeパラメータを更新する
     * @param type
     */
    setType(type) {
        if (!RankingStore.isTypeValid(type)) {
            throw new Error("Given type is invalid");
        }

        // typeが更新されていればpageを1に戻す
        if (this.type !== type) {
            this.page = 1;
        }
        this.type = type;

        this._emitUpdateEvent()
    }

    setDuration(duration) {
        if (!RankingStore.isDurationValid(duration)) {
            throw new Error("Given duration is invalid");
        }

        // durationが更新されていればpageを1に戻す
        if (this.duration !== duration) {
            this.page = 1;
        }

        // durationとtypeが矛盾していれば、typeをbreakにする
        if (!RankingTypes.getAvailableTypes(duration).includes(this.type)) {
            this.type = "break";
        }

        this.duration = duration;
        this._emitUpdateEvent();
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