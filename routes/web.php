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

/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', 'HomeController@index')->name('home');
Route::get('/my', 'HomeController@dashboard')->name('dashboard')->middleware('auth');


Route::get('/api/balances', 'ApiController@getBalances')->middleware('auth');
Route::get('/api/balances/refresh', 'ApiController@refreshBalance');

Route::get('/api/rock/orders/{instrument}', 'ApiController@getOrders')->middleware('auth');
Route::delete('/api/rock/order/{instrument}', 'ApiController@deleteOrder')->middleware('auth');
Route::put('/api/rock/order/{instrument}', 'ApiController@createOrder')->middleware('auth');
//Route::get('/my/{catchall?}', 'HomeController@my')->name("my")->where('catchall', '(.*)');


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tickers', 'HomeController@getTickers')->name('tickers');
Route::get('/funds', 'HomeController@getFunds')->name('funds');

