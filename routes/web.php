<?php

use Laravel\Lumen\Routing\Router;
use Ramsey\Uuid\Uuid;

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

/** @var Router $router */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Generate random string
$router->get(
    'appKey', function () {
    return Uuid::uuid4()->toString();
}
);

// route for creating access_token
$router->post('accessToken', 'AccessTokenController@createAccessToken');
