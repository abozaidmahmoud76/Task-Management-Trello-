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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->post('/register','AuthController@register');
$router->post('/login','AuthController@login');
$router->get('/logout','AuthController@logout');

//boards routes
$router->get('/boards','BoardController@index');
$router->get('/boards/{board}','BoardController@show');
$router->post('/boards','BoardController@store');
$router->post('/boards/{id}','BoardController@update');
$router->delete('/boards/{id}','BoardController@delete');


//lists routes
$router->get('/boards/{board}/list','ListController@index');
$router->get('/boards/{board}/list/{list}','ListController@show');
$router->post('/boards/{board}/list','ListController@store');
$router->post('/boards/{board}/list/{list}','ListController@update');
$router->delete('/boards/{board}/list/{list}','ListController@delete');

//card routes
$router->get('/boards/{board}/list/{list}/card','CardController@index');
$router->get('/boards/{board}/list/{list}/card/{card}','CardController@show');
$router->post('/boards/{board}/list/{list}/card','CardController@store');
$router->post('/boards/{board}/list/{list}/card/{card}','CardController@update');
$router->delete('/boards/{board}/list/{list}/card/{card}','CardController@delete');