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

// お問い合わせ
Route::get('/contact', 'PagesController@contact');

// アイディア投稿フォーム
Route::get('/ideaForm', 'IdeaFormController@index');
Route::post('/ideaForm/submit', 'IdeaFormController@submit');

// JMSログイン・ログアウト
Route::get('login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
Route::get('logout/{provider}',         'Auth\SocialAccountController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
