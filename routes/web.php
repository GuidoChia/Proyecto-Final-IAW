<?php

use App\Customer;
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

Route::get('/',
    function () {
        $customer = Customer::where('name', '=', 'Municipalidad')->first();
        $isPredicted = $customer->predictBuy(now());
        if ($isPredicted)
            return view('welcome')->withCustomer($customer->name);
        else
            return view('welcome');
    });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

