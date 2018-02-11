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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/question/{id}', 'QuestionController@index');

Route::get('/ask', function () {
    return view('ask');
});

Route::get('/question', function () {
    return view('question');
});

Route::resource('/reply', 'ReplyController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
