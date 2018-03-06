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

//home page with question listing
Route::get('/', array('as' => 'welcome', 'uses' => 'QuestionController@index'));
Route::get('/home', array('as' => 'welcome', 'uses' => 'QuestionController@index'));

//home page search
Route::post('/home', array('as' => 'welcome', 'uses' => 'SearchController@search'));

//to get to ask page and store new question
Route::post('/ask', 'QuestionController@store');
Route::get('/ask', array('as' => 'ask', function () {
    return view('ask');
}));

//to show question page of a specific question
Route::get('/question/{id}', 'QuestionController@show');

//to store reply to questions
Route::post('/question/reply/{id}', 'ReplyController@store');

//to like or dislike a reply
Route::get('/question/like/{id}', 'LikeController@like');
Route::get('/question/dislike/{id}', 'LikeController@dislike');

//to accept, reject or normalize a reply
Route::get('/question/accept/{id}', 'LikeController@accept');
Route::get('/question/reject/{id}', 'LikeController@reject');
Route::get('/question/normalize/{id}', 'LikeController@normalize');

//to order questions
Route::get('/home/{order}/{direction}', 'QuestionController@order');

//user profile view and editing
Route::get('/profile', array('as' => 'profile', 'uses' => 'ProfileController@index'));
Route::post('/profile', 'ProfileController@edit');

//login, register
Auth::routes();

?>
