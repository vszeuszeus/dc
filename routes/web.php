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

Route::group(['middleware' => 'auth'], function (){

    Route::get('/admin', 'AdminController@index')->name('admin');

    Route::resource('categories', 'CategoryController');

    Route::group(['prefix' => 'lectures'], function(){
        Route::get('searcher', 'LectureController@search');
        Route::delete('destroyWeb/{id}', 'LectureController@destroyWeb')->name('lectures.destroyWeb');
    });
    Route::resource('lectures', 'LectureController');

    Route::resource('tests', 'TestController');

    Route::resource('questions', 'QuestionController');

    Route::resource('answers', 'AnswerController');

});




