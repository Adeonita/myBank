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

$router->post('/users', 'UserController@create');
$router->get('/users', 'UserController@getAll');
$router->get('/users/{id}', 'UserController@find');
$router->get('/users/{userId}/wallet', 'WalletController@getByUser');

$router->post('/transactions', 'TransactionController@create');
$router->get('/transactions/users/{userId}', 'TransactionController@getByUser');