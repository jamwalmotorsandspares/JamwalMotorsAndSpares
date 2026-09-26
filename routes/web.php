<?php

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
Route::group(['prefix' => LaravelLocalization::setLocale(),
'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],['TrackPageActivity']],
function(){
    Auth::routes();

    Route::get('/', 'HomeController@index')->name('home');
    // products routes
    Route::get('/products', 'ProductController@index')->name('products.index');
    Route::get('/products/{product}', 'ProductController@show')->name('products.show');
    // users routes
    Route::resource('users', 'UserController')->only(['index','update']);
    // carts routes
    Route::resource('carts', 'CartController')->only(['index','store','update']);
    // order route get
    Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
    // checkout routes
    Route::resource('checkout', 'CheckoutController')->only(['create','store']);
    Route::get('/callback', 'CheckoutController@callback')->name('callback');
    Route::get('/latest-order', 'CheckoutController@latestOrder')->name('order.latest');

});

Route::post('/visitor/navigation','VisitorHistoryController@navigation')->name('visitor.navigation');


// Route::get('/payment/razorpay/create-order/{order}','RazorpayController@createOrder')->name('razorpay.createOrder');
Route::post('/payment/razorpay/create-order','RazorpayController@createOrder')->name('razorpay.createOrder');

Route::post('/payment/razorpay/verify','RazorpayController@verify')->name('razorpay.verify');

Route::post('/payment/razorpay/webhook','RazorpayController@webhook')->name('razorpay.webhook');





