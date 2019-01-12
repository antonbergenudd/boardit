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

Route::get('/', 'MainController@index');
Route::get('/games', 'MainController@games')->name('games');
Route::get('/about', 'MainController@about')->name('about');

Route::prefix('cart')->name('cart.')->group(function() {
    Route::get('{product}/add', 'CartController@add')->name('add');
    Route::get('{rowId}/remove', 'CartController@remove')->name('remove');
    Route::get('destroy', 'CartController@destroy')->name('destroy');
});

Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('index', 'PaymentController@index')->name('index');
    Route::post('confirm', 'PaymentController@confirm')->name('confirm');
});

Route::prefix('auth')->name('auth.')->middleware('restrict')->group(function() {
    Route::get('orders', 'MainController@orders')->name('orders');
});
