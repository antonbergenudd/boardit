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

Route::get('/', 'MainController@index')->name('index');

// Routes
Route::get('/games', 'MainController@games')->name('games');
Route::get('/about', 'MainController@about')->name('about');
Route::get('/faq', 'MainController@faq')->name('faq');
Route::get('/policy', 'MainController@policy')->name('policy');

// SMS
Route::get('/sms/reply', 'MainController@receiveSms')->name('sms.reply');

// Cart
Route::prefix('cart')->name('cart.')->group(function() {
    Route::get('{product}/add', 'CartController@add')->name('add');
    Route::get('{id}/remove', 'CartController@removeById')->name('remove');
    Route::get('rowid/{rowId}/remove', 'CartController@removeByRowId')->name('remove.rowid');
    Route::get('destroy', 'CartController@destroy')->name('destroy');
});

// Payment
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('index', 'PaymentController@index')->name('index');
    Route::post('submit', 'PaymentController@submit')->name('submit');
});

// General
Route::post('check/discount', 'PaymentController@controlDiscount')->name('check.discount');

// Auth
Route::prefix('auth')->name('auth.')->middleware(['auth'])->group(function() {
    Route::get('orders', 'MainController@orders')->name('orders');
    Route::get('user/{user}/confirm/order/{order}', 'MainController@confirmOrder')->name('confirm.order');
    Route::get('user/{user}/return/order/{order}', 'MainController@returnOrder')->name('return.order');
    Route::get('user/{user}/deliver/order/{order}', 'MainController@deliverOrder')->name('deliver.order');
    Route::post('employee/{user}/delivering', 'MainController@delivering')->name('delivering');
    Route::post('control/order', 'MainController@controlOrder')->name('order.control');
});

Auth::routes();
