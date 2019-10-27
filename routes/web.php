<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/sms/reply', 'OrderController@receiveSms')->name('sms.reply');

// Cart
Route::prefix('cart')->name('cart.')->group(function() {
    Route::get('{product}/add', 'CartController@add')->name('add');
    Route::get('{id}/remove', 'CartController@removeById')->name('remove');
    Route::get('rowid/{rowId}/remove', 'CartController@removeByRowId')->name('remove.rowid');
    Route::get('destroy', 'CartController@destroy')->name('destroy');
});

// Products
Route::prefix('product')->name('product.')->group(function() {
    Route::get('{product}/view', 'ProductController@view')->name('view');
});

// Payment
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('index', 'PaymentController@index')->name('index');
    Route::get('feedback', 'PaymentController@feedback')->name('feedback');
    Route::post('submit', 'PaymentController@submit')->name('submit');
});

// General
Route::post('check/discount', 'PaymentController@controlDiscount')->name('check.discount');
Route::get('{order}/status', 'OrderController@status')->name('order.status');
Route::post('{order}/status/failed', 'OrderController@setFailed')->name('order.status.failed');
Route::post('{order}/notify/offline', 'OrderController@notifyOffline')->name('notify.offline');
Route::get('{order}/reminder', 'OrderController@orderReminder')->name('reminder');
Route::get('{cart_product_id}/quantity', 'OrderController@quantity')->name('cart.product.quantity');

// Auth
Route::prefix('auth')->name('auth.')->middleware(['auth'])->group(function() {

    // Orders
    Route::get('orders', 'OrderController@index')->name('orders');
    Route::get('user/{user}/confirm/order/{order}', 'OrderController@confirm')->name('confirm.order');
    Route::get('user/{user}/return/order/{order}', 'OrderController@return')->name('return.order');
    Route::get('user/{user}/deliver/order/{order}', 'OrderController@deliver')->name('deliver.order');

    Route::post('employee/{user}/delivering', 'AuthController@delivering')->name('delivering');
});

Auth::routes();
