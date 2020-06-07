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
    $router->get('categories', ['uses' => 'CategoryController@index']);
    $router->get('categories/{id}', ['uses' => 'CategoryController@show']);
//    $router->get('files', ['uses' => 'FileController@index']);

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('files', ['uses' => 'FileController@create']);
        $router->get('files/{id}', ['uses' => 'FileController@show']);
        $router->put('files/{id}', ['uses' => 'FileController@update']);

        $router->post('files/{id}', ['uses' => 'FileController@download']);
        $router->post('files/{id}/rate', ['uses' => 'FileController@toRate']);
    });
});