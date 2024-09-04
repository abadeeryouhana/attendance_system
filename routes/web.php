<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['middleware' => ['x-api-key'],'prefix' => 'auth'], function ($router) {

    $router->post('login', 'UserController@login');

});

$router->group(['middleware' => ['x-api-key','app_user'],'prefix' => 'attend'], function ($router) {

    $router->post('check_in', 'UserAttendController@check_in');

});

