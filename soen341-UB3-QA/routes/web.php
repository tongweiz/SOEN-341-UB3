<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

//home page
Route::get('/', array('as' => 'welcome', 'uses' => 'QuestionController@index'));

Route::get('/home', array('as' => 'welcome', 'uses' => 'QuestionController@index'));

//home page search
Route::post('/home', array('as' => 'welcome', 'uses' => 'SearchController@search'));

Route::post('/ask', 'QuestionController@store');

Route::get('/ask', array('as' => 'ask', function () {
    return view('ask');
}));

Route::get('/question/{id}', 'QuestionController@show');
Route::post('/question/reply/{id}', 'ReplyController@store');
Route::get('/question/like/{id}', 'LikeController@like');
Route::get('/question/dislike/{id}', 'LikeController@dislike');
Route::get('/question/accept/{id}', 'LikeController@accept');
Route::get('/question/reject/{id}', 'LikeController@reject');
Route::get('/question/normalize/{id}', 'LikeController@normalize');

Auth::routes();

?>
