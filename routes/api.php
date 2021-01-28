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
Route::get('/memorize','API\Form\MemorizeController@index');

Route::get('/products','API\Store\ProductController@index');
Route::get('/product/lesson/{lesson}/memorize/items','API\Form\MemorizeController@getItems');


