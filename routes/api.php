<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// プレーヤー検索API
Route::get('/search/player', 'Api\PlayerSearch@get');

// ランキングAPI
Route::get('/ranking', 'Api\PlayerRanking@get');
//Route::get('/ranking/player/{player_uuid}', 'Api\PlayerRanking@getPlayerRank');
Route::group(['prefix' => 'api', 'middleware' => 'throttle:180'], function () {
    Route::get('/ranking/player/{player_uuid}', 'Api\PlayerRanking@getPlayerRank');
});

// プレーヤーデータAPI
Route::get('/players/{player_uuid}/{data_type}', 'Api\PlayerData@getPlayerData');
