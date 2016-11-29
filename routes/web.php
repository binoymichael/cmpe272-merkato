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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/products', 'HomeController@products');

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

Route::resource('sellers', 'SellersController', ['only' => [
    'index', 'show'
]]);

Route::resource('sellers.products', 'ProductsController', ['only' => [
    'show'
]]);

Route::get('/recent', 'ProductsController@recent');

Route::post('/cart', 'CartController@store');
Route::get('/cart', 'CartController@index');
Route::patch('/cart', 'CartController@update');

Route::get('/orders/create', 'OrdersController@create');
Route::post('/orders', 'OrdersController@store');

Route::resource('sellers.products.reviews', 'ReviewsController', ['only' => [
	'store'
]]);
