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
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {

    //public routing
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('/login', 'UsersController@login');
        $router->post('/register', 'UsersController@store');
        $router->get('/', 'UsersController@index');

        $router->get('/book', 'BooksController@index');
        $router->post('/book/ad', 'BooksController@store');
        $router->get('/koleksi/{id}', 'KoleksiController@getByUser');
        $router->post('/koleksi', 'KoleksiController@store');
        $router->get('/ulasan/{id}', 'UlasanController@getByUser');
        $router->post('/ulasan', 'UlasanController@store');
        $router->get('/pinjam/{id}', 'PeminjamanController@getByUser');
        $router->post('/pinjam', 'PeminjamanController@store');
    });
    $router->group(['prefix' => 'petugas'], function () use ($router) {
        $router->post('/login', 'UsersController@loginPetugas');
        
        // $router->post('/book', 'BooksController@store');
        $router->post('/book/{id}', 'BooksController@getByID');
        $router->get('/book/{id}', 'BooksController@getByID');
        $router->get('/book', 'BooksController@index');
        $router->get('/kategori', 'KategoriController@index');
        $router->get('/pinjam', 'PeminjamanController@index');
    });

});
