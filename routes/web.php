<?php

use Illuminate\Support\Facades\Response;
use Laravel\Lumen\Routing\Router;

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
$router->get(
    '/', function () use ($router) {
    return (new \Illuminate\Http\Response(
        '', 302, [
              'Location' => '/schema/index.html',
          ]
    ));
}
);
