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

$router->post('/register', ['uses' => 'UserController@register']);
$router->post('/login', ['uses' => 'AuthController@authenticate']);
$router->group(['middleware' => 'jwt.auth'], function() use ($router) {
	$router->get('/users',['uses' => 'UserController@index']);
	$router->get('/users/{id}',['uses' => 'UserController@show']);
	$router->put('/users/{id}',['uses' => 'UserController@update']);
	$router->put('/users/update-avatar/{id}',['uses' => 'UserController@updateUserAvatar']);
	$router->delete('/users/{id}',['uses' => 'UserController@delete']);
});