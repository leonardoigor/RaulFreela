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
    return view('main');
});

$router->get('teste', function () {
    // return BaseGoverno::take(1)->first();
    return view('index');
});
$router->post('upload', 'UploadController@upload');
$router->post('upload_margem', 'UploadController@upload_margem');
$router->get('info', function () {
    return phpinfo();
});

$router->get('/thread', function () {
    $thread = new Thread(function ($message) {
        echo $message;
    });
    dd($thread);
});
