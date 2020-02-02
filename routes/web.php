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

Route::get('/', 'TriviaController@index');
Route::get('/user/{trivia}', 'TriviaController@show_user_admin');
Route::post('/user/{trivia}/create', 'TriviaController@create_trivia');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
