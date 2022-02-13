<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Models\BaseGoverno;

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

$router->get('teste', function () {
    // dd('s');
    // return BaseGoverno::take(1)->first();
    return view('index');
});
$router->post('upload', 'UploadController@upload');
$router->get('info', function () {
    return phpinfo();
});
