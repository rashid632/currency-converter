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

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function(){
    Route::get('/user', function( Request $request ){
        return $request->user();
    });

    /*
    |-------------------------------------------------------------------------------
    | Convert the currency provided.
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/convert
    | Controller:     CurrencyController@convert
    | Method:         GET
    | Description:    Convert the currency provided
    */
    Route::get('/convert', 'CurrencyController@convert');

    /*
    |-------------------------------------------------------------------------------
    | Get all currency types provided.
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/getCurrencyTypes
    | Controller:     CurrencyController@getCurrencyTypes
    | Method:         GET
    | Description:    Get all currency types provided
    */
    Route::get('/getCurrencyTypes', 'CurrencyController@getCurrencyTypes');

});
