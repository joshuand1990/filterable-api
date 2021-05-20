<?php

/** @var Router $router */

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

use App\Http\Middleware\ForceXmlMiddleware;
use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('api/listings', [ 'uses' => \App\Http\Controllers\ListingsController::class .'@index', 'middleware' => [ ForceXmlMiddleware::class ] ]);
