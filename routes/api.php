<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('images/upload', 'Api\ImageController@upload')->name('api-images-upload');

Route::group(['prefix' => 'products'], function() {
    Route::get('search', 'Api\ProductController@search')->name('api-products-search');
    Route::get('{id?}', 'Api\ProductController@get')->name('api-products-get');
    Route::get('warehouse/{id?}', 'Api\ProductController@getWarehouse')->name('api-products-warehouse-get');
});
