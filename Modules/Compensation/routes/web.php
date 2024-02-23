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

Route::group(['prefix'=>'compensation','middleware' => ['permission:compensation.view']],function(){
    Route::get('/', 'CompensationController@index');
});

Route::group(['prefix'=>'compensation','middleware' => ['permission:compensation.add']],function(){
    Route::get('/create', 'CompensationController@create');
    Route::POST('/store', 'CompensationController@store');
});
Route::group(['prefix'=>'compensation','middleware' => ['permission:compensation.edit']],function(){
    Route::get('/edit/{id}', 'CompensationController@edit');
    Route::POST('/update/{id}', 'CompensationController@update');
});
Route::group(['prefix'=>'compensation','middleware' => ['permission:compensation.delete']],function(){
    Route::get('/destroy/{id}', 'CompensationController@destroy');
});