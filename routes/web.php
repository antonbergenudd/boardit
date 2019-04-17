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
Route::get('/faq', 'MainController@faq')->name('faq');
Route::get('/policy', 'MainController@policy')->name('policy');

Route::prefix('cart')->name('cart.')->group(function() {
    Route::get('{product}/add', 'CartController@add')->name('add');
    Route::get('{rowId}/remove', 'CartController@remove')->name('remove');
    Route::get('destroy', 'CartController@destroy')->name('destroy');
});

Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('index', 'PaymentController@index')->name('index');
    Route::post('submit', 'PaymentController@submit')->name('submit');

});

Route::prefix('auth')->name('auth.')->middleware(['restrict', 'auth'])->group(function() {
    Route::get('orders', 'MainController@orders')->name('orders');
    Route::get('{order}/confirm', 'MainController@confirmOrder')->name('confirm.order');
});

Auth::routes();
