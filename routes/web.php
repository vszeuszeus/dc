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

Route::group(['middleware' => 'auth'], function (){

    Route::group(['prefix' => 'home'], function (){
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/lecture/{id}', 'HomeController@readLecture')->name('home.readLecture');
        Route::get('/test/begin/{id}', 'HomeController@beginTest')->name('home.beginTest');
        Route::get('/getCertificate/{id}', 'HomeController@getCertificate')->name('home.getCertificate');
        Route::get('/testResult', 'HomeController@testResult')->name('home.testResult');
    });

    Route::get('/admin', 'AdminController@index')->name('admin');

    Route::resource('categories', 'CategoryController');

    Route::group(['prefix' => 'lectures'], function(){
        Route::get('searcher', 'LectureController@search');
        Route::get('getByCategory/{id}', 'LectureController@getByCategory');
        Route::delete('destroyWeb/{id}', 'LectureController@destroyWeb')->name('lectures.destroyWeb');
    });
    Route::resource('lectures', 'LectureController');

    Route::resource('tests', 'TestController');

    Route::resource('questions', 'QuestionController');

    Route::group(['prefix' => 'answers'], function(){
        Route::put('{id}/setTrusted', 'AnswerController@setTrusted');
    });
    Route::resource('answers', 'AnswerController');

});




