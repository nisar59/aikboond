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

Route::group(['prefix'=>'areas','middleware' => ['permission:areas.view']],function(){
    Route::get('/', 'AreasController@index');
   
});

Route::group(['prefix'=>'areas','middleware' => ['permission:areas.add']],function(){
    Route::get('/create', 'AreasController@create');
    Route::POST('/store', 'AreasController@store');


});
Route::group(['prefix'=>'areas','middleware' => ['permission:areas.edit']],function(){
    Route::get('/edit/{id}', 'AreasController@edit');
    Route::POST('/update/{id}', 'AreasController@update');
});
Route::group(['prefix'=>'areas','middleware' => ['permission:areas.delete']],function(){
    Route::get('/destroy/{id}', 'AreasController@destroy');
});

