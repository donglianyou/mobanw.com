<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resources([
        'users'             =>  UserController::class,
        'categories'        =>  CategoryController::class,
        'articles'          =>  ArticleController::class,
        'plugins'           =>  PluginController::class,
        'tags'              =>  TagController::class,
        'templates'         =>  TemplateController::class,
        'orders'            =>  OrderController::class,
        'settings'          =>  SettingController::class,
        'ads'               =>  AdController::class,
        'charts'            =>  ChartController::class,
        'backup'            =>  BackupController::class,
        'restore'           =>  RestoreController::class,
        'exchanges'         =>  ExchangeController::class,
        'payments'         =>  PaymentController::class,
        'comments'         =>  CommentController::class,
    ]);
});
