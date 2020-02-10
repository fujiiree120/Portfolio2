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

Auth::routes();
//トップページの表示
Route::get('/', 'TriviaController@index');

//トリビア詳細ページの表示
Route::get('/{trivia}/detail', 'TriviaController@show_trivia_detail');

//ユーザーランキングページを表示
Route::get('/rank', 'TriviaController@show_user_rank');

//ユーザーのマイページを表示
Route::get('/{trivia}/user', 'TriviaController@show_user_trivia');

//ユーザーの管理ページを表示
Route::get('/user/{trivia}', 'TriviaController@show_user_index');

//ユーザーの管理ページにてトリビアの修正を行う
Route::post('/user/{trivia}/create', 'TriviaController@create_trivia');
Route::patch('/user/{trivia}/name', 'TriviaController@update_name');
Route::patch('/user/{trivia}/body', 'TriviaController@update_body');
Route::patch('/user/{trivia}/genre', 'TriviaController@update_genre');
Route::delete('/user/{trivia}/body', 'TriviaController@destroy_trivia');

//投票結果を反映させる
Route::post('/vote', 'VoteController@is_valid_trivia_vote');

//adminページの表示
Route::get('/admin', 'HomeController@show_admin');
Route::post('/admin/create', 'TriviaController@create_genre');

Route::get('/login/{social}', 'Auth\TwitterController@socialLogin')->where('social', 'twitter');
Route::get('/login/twitter/callback', 'Auth\TwitterController@handleProviderCallback')->where('social', 'twitter');
