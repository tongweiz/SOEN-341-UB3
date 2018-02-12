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

Route::get('/details', array('as' => 'details', function () {
    return view('details');
}));

Route::get('/ask', array('as' => 'ask', function () {
    return view('ask');
}));

Route::get('/question', array('as' => 'question', function () {
    return view('question');
}));

Auth::routes();

?>