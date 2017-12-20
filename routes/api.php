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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tickers/list', 'ApiController@getListTickers');
Route::get('/ticker/last', 'ApiController@getLastTicker');
Route::get('/tickers/analyze', 'ApiController@analyzeTickers');
Route::get('/balances3/{currency?}', 'ApiController@getBalances3');
Route::get('/rock/tickers', 'ApiController@getTickers');
Route::get('/rock/ticker/{instrument}', 'ApiController@getTicker');
Route::get('/rock/orders/{instrument}', 'ApiController@getOrders');
Route::get('/rock/orderbook/{instrument}/{limit?}', 'ApiController@getOrderbook');


