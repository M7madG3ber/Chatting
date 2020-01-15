<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user/{id}', 'HomeController@userSession');

Route::post('/user/sendmessage', 'HomeController@sendMessage');

Route::post('/getallmessages', 'HomeController@getAllMessages');
Route::get('/getallmessages', 'HomeController@getAllMessages');

Route::post('/deleteMessages', 'HomeController@deleteMessages');

