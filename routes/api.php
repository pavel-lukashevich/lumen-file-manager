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

$router->group(['prefix' => 'api/v1', 'namespace' => 'Api\V1'], function () use ($router) {
    $router->get('category', ['uses' => 'CategoryController@index']);
    $router->get('file', ['uses' => 'FileController@index']);

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('file', ['uses' => 'FileController@create']);
        $router->get('file/{id}', ['uses' => 'FileController@show']);
        $router->get('file/{id}/download', ['uses' => 'FileController@download']);
        $router->put('file/{id}', ['uses' => 'FileController@update']);
    });
});