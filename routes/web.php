<?php

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

$router->get('/', function () {
  return redirect('/api');
});

$router->group(['prefix' => 'api', 'namespace' => 'Api'], function ($router) {

  $router->get('/', function () use ($router) { return $router->app->version(); });
  
  $router->post('register', 'AuthController@register');
  $router->post('login', 'AuthController@login');

  $router->group(['middleware' => 'auth'], function ($router) {

    $router->group(['prefix' => 'user'], function ($router) {
      $router->get('/', 'AuthController@me');
    });

  });

});