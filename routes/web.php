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
Route::get('/{trivia}/detail', 'TriviaController@show_trivia_detail');
Route::get('/user/{trivia}', 'TriviaController@show_user_admin');
Route::post('/user/{trivia}/create', 'TriviaController@create_trivia');
Route::patch('/user/{trivia}/name', 'TriviaController@update_name');
Route::patch('/user/{trivia}/body', 'TriviaController@update_body');
Route::delete('/user/{trivia}/body', 'TriviaController@destroy_trivia');
Route::post('/vote', 'VoteController@is_valid_trivia_vote');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
