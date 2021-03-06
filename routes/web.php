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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get('/key', function () {
    return str_random(32);
});


$app->group(['prefix' => 'api'], function () use ($app) {
    $app->get('pegawais', 'PegawaiController@index');
    $app->get('pegawais/unit/{unit}', 'PegawaiController@pegawai_unit');
    $app->get('pegawais/search/{keyword}', 'PegawaiController@search');
    $app->get('pegawai/{id}', 'PegawaiController@detail');
    $app->get('bkds/{tahun}/{semester}', 'BkdController@list_by_semester');
    $app->get('bkds/{tahun}/{semester}/{unit}', 'BkdController@list_by_unit');
    $app->get('bkd/{tahun}/{semester}/{pegawai}', 'BkdController@list_by_pegawai');
});
