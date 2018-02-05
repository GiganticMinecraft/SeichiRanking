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

/**
 * サイト表示
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

// JMSログイン・ログアウト
Route::get('login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
Route::get('logout/{provider}',         'Auth\SocialAccountController@logout');

/**
 * 管理用ページ
 */
// TOP
Route::get('/admin', 'AdminController@index');

// お問い合わせ管理
//Route::get('/admin/inquiry', 'AdminController@inquiry');
//Route::get('/admin/inquiry/detail', 'AdminController@inquiry_detail');
//Route::post('/admin/inquiry/submit', 'AdminController@inquiry_submit');

// アカウント管理
Route::get('/admin/account', 'AdminController@account');
// ログイン/ログアウト
Route::get('/admin/login', 'AdminController@login');
Route::get('/admin/logout', 'AdminController@logout');

Auth::routes();
