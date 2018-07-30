<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// TOP
Route::get('/', 'RankingController@index');
Route::get('/ranking/{mode}', 'RankingController@index');

// このページについて
Route::get('/about', 'PagesController@about');

// アイディア投稿フォーム
Route::get('/ideaForm', 'Form\IdeaFormController@index');
Route::post('/ideaForm/submit', 'Form\IdeaFormController@submit');

// お問い合わせフォーム
Route::get('/inquiryForm', 'Form\inquiryFormController@index');
Route::post('/inquiryForm/submit', 'Form\InquiryFormController@submit');

Route::get('/thanks', 'PagesController@thanks');

// プレイヤー詳細
Route::get('/player/{player}', 'PlayerController@index');

// 建築コンペ投票ページ
Route::get('/buildCompetition', 'BuildCompetitionController@index');
Route::post('/buildCompetition/submit', 'BuildCompetitionController@submit');

// 建築コンペ応募ページ
//Route::get('/buildCompetition/apply', 'BuildCompetitionController@apply');
//Route::post('/buildCompetition/apply/submit', 'BuildCompetitionController@applySubmit');

// JMSログイン・ログアウト
Route::get('login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
Route::get('logout/{provider}',         'Auth\SocialAccountController@logout');

Auth::routes();
