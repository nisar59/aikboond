<?php

use Illuminate\Support\Facades\Route;
use Modules\UnionCouncils\App\Http\Controllers\UnionCouncilsController;

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

Route::group(['prefix'=>'union-councils','middleware' => ['permission:union-councils.view']],function(){
    Route::get('/', 'UnionCouncilsController@index');
});

Route::group(['prefix'=>'union-councils','middleware' => ['permission:union-councils.add']],function(){
    Route::get('/create', 'UnionCouncilsController@create');
    Route::get('import', 'UnionCouncilsController@import');
    Route::POST('/store', 'UnionCouncilsController@store');
    Route::POST('/importUpload', 'UnionCouncilsController@importUpload');

});
Route::group(['prefix'=>'union-councils','middleware' => ['permission:union-councils.edit']],function(){
    Route::get('/edit/{id}', 'UnionCouncilsController@edit');
    Route::POST('/update/{id}', 'UnionCouncilsController@update');
});
Route::group(['prefix'=>'union-councils','middleware' => ['permission:union-councils.delete']],function(){
    Route::get('/destroy/{id}', 'UnionCouncilsController@destroy');
});