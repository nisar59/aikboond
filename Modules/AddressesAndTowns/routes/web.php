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
	Route::group(['prefix'=>'addresses-and-towns','middleware' => ['permission:addresses-and-towns.view']],function(){
	    Route::get('/', 'AddressesAndTownsController@index');
	});

	Route::group(['prefix'=>'addresses-and-towns','middleware' => ['permission:addresses-and-towns.add']],function(){
	    Route::get('/create', 'AddressesAndTownsController@create');
	    Route::POST('/store', 'AddressesAndTownsController@store');


	});
	Route::group(['prefix'=>'addresses-and-towns','middleware' => ['permission:addresses-and-towns.edit']],function(){
	    Route::get('/edit/{id}', 'AddressesAndTownsController@edit');
	    Route::POST('/update/{id}', 'AddressesAndTownsController@update');
	});
	Route::group(['prefix'=>'addresses-and-towns','middleware' => ['permission:addresses-and-towns.delete']],function(){
	    Route::get('/destroy/{id}', 'AddressesAndTownsController@destroy');
	});