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

/**
 * ##################
 * ### ROTA PING ###
 * ##################
 */

$router->get('/', function () use ($router) {
    return redirect('/ping');
});

$router->get('/ping', function () use ($router) {
    return ['data' => ['ping' => 'pong', 'versão' => '1.0.0']];
});

/**
 * ##################
 * ### ROTA 401 ###
 * ##################
 */

$router->get('/401', [
    'as' => 'login', 'uses' => 'AuthController@unauthorized'
]);

/**
 * ##################
 * ### ROTAS AUTH ###
 * ##################
 */

$router->post('api/auth/register', 'AuthController@register');
$router->post('api/auth/login', 'AuthController@login');
$router->post('api/auth/logout', ['middleware' => 'auth', 'uses' => 'AuthController@logout']);
$router->post('api/auth/refresh', ['middleware' => 'auth', 'uses' => 'AuthController@refresh']);

/**
 * ##################
 * ### ROTAS USUARIOS ###
 * ##################
 */

$router->group([
    'middleware' => 'auth',
    'prefix' => 'api/user'
], function () use ($router) {
    $router->get('/', 'UserController@read');
    $router->put('/update', 'UserController@update');
    $router->post('/avatar','UserController@updateAvatar');
    $router->get('/favorites', 'UserController@getFavorites');
    $router->post('/favorite', 'UserController@addFavorite');
    $router->get('/appointments', 'UserController@getAppointments');
});

/**
 * ##################
 * ### ROTAS PROFESSIONALS ###
 * ##################
 */

$router->group([
    'middleware' => 'auth',
    'prefix' => 'api/professionals'
], function () use ($router) {
    $router->get('/', 'ProfessionalController@list');
    $router->get('/professional/{professional}', 'ProfessionalController@one');
    $router->get('/search', 'ProfessionalController@search');
    $router->post('/professional/{professional}/appointment', 'ProfessionalController@setAppointment');
});
