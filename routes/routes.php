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
    return redirect('/ping');
});

$router->get('/ping', function () use ($router) {
    return ['data' => ['ping' => 'pong', 'versão' => '1.0.0']];
});

// rotas publicas de autenticação
$router->post('api/auth/register', 'AuthController@register');
$router->post('api/auth/login', 'AuthController@login');
$router->post('api/auth/logout', 'AuthController@logout');
$router->post('api/auth/refresh', 'AuthController@refresh');

// rota de usuarios
$router->group([
    'prefix' => 'api/user'
], function () use ($router) {
    $router->get('/', 'UserController@read');
    $router->put('/update/{user}', 'UserController@update');
    $router->get('/favorites', 'UserController@getFavorites');
    $router->get('/favorite', 'UserController@addFavorite');
    $router->get('/appointments', 'UserController@getAppointments');
});

// rota de profissionais
$router->group([
    'prefix' => 'api/professionals'
], function () use ($router) {
    $router->get('/', 'ProfessionalController@list');
    $router->get('/professional/{professional}', 'ProfessionalController@one');
    $router->get('/search', 'ProfessionalController@search');
    $router->post('/professional/{professional}/appointment', 'ProfessionalController@setAppointment');
});
