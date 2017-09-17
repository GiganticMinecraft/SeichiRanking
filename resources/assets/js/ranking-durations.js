export default class RankingDuration {
    static get DURATION_MAP() {
        return {
            "total" : "総合",
            "daily" : "日間",
            "weekly" : "週間",
            "monthly" : "月間",
            "yearly" : "年間"
        };
    }

    /**
     * ランキング期間を日本語に解決する
     * @param duration
     * @returns string
     */
    static resolveRaw(duration) {
        return RankingDuration.DURATION_MAP[duration];
    }

    static getAvailableDurations() {
        return Object.keys(RankingDuration.DURATION_MAP);
    }
}