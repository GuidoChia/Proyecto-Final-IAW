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

Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/prediction', 'RoutePredictionController@predictDate')->name('prediction-date');
Route::get('/prediction', 'RoutePredictionController@index')->name('prediction');

Route::post('/add-address', 'AddAddressController@index')->name('add-address');
Route::get('/add-address', 'AddAddressController@index')->name('add-address');

Route::post('/add-buy', 'AddBuyController@index')->name('add-buy');
Route::get('/add-buy', 'AddBuyController@index')->name('add-buy');

Route::post('/add-customer', 'AddCustomerController@index')->name('add-customer');
Route::get('/add-customer', 'AddCustomerController@index')->name('add-customer');

Route::post('/remove-address', 'RemoveAddressController@index')->name('remove-address');
Route::get('/remove-address', 'RemoveAddressController@index')->name('remove-address');

Route::post('/remove-buy', 'RemoveBuyController@index')->name('remove-buy');
Route::get('/remove-buy', 'RemoveBuyController@index')->name('remove-buy');

Route::post('/remove-customer', 'RemoveCustomerController@index')->name('remove-customer');
Route::get('/remove-customer', 'RemoveCustomerController@index')->name('remove-customer');

Route::post('/search-customer', 'SearchCustomerController@index')->name('search-customer');
Route::get('/search-customer', 'SearchCustomerController@index')->name('search-customer');