import fetch from 'isomorphic-fetch';

const endpoint_root = "/api";

export default class RankingApi {
    static searchPlayer(query, lim = 20) {
        return fetch(`${endpoint_root}/search/player?q=${query}&lim=${lim}`);
    }

    static getRanking(type = "break", offset = 1, lim = 100) {
        return fetch(`${endpoint_root}/ranking?type=${type}&offset=${offset}&lim=${lim}`);
    }

    static getPlayerRanking(player_uuid, types="break,build,playtime,vote") {
        return fetch(`${endpoint_root}/ranking/player/${player_uuid}&types=${types}`)
    }
}
