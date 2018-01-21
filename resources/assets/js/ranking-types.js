export default class RankingTypes {
    static get TYPE_MAP () {
        return {
            "break": "整地量",
            "build": "建築量",
            "playtime": "接続時間",
            "vote": "投票数"
        };
    }

    /**
     * ランキングタイプを日本語に解決する
     * @param type
     * @returns string
     */
    static resolveRaw(type) {
        return RankingTypes.TYPE_MAP[type];
    }

    /**
     * 期間パラメータに対して有効な型の配列を返す
     * @param duration
     * @returns {[string]}
     */
    static getAvailableTypes(duration) {
        const types = ["break", "build", "playtime"];
        if (duration === "daily") {
            return types;
        }
        types.push("vote");
        return types;
    }
}
