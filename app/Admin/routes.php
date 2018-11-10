<?php

use Illuminate\Routing\Router;
use Encore\Admin\Facades\Admin;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    // 建築コンペ：テーマ管理
    $router->resource('buildCompetition/theme', BuildCompetitionThemeController::class);

});
