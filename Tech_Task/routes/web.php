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

Route::get('/', function () {
    return view('login');
});



route::post('/create', 'LoginController@create');
route::get('/register', 'LoginController@register');
route::post('/check', 'LoginController@checkUser');

Route::get('/transaction','LoginController@protect');
Route::get('/logout','LoginController@logout');

Route::post('/apiRequest','api@apiRequest');
Route::post('/requests/','api@apiRequest');



Route::get('/paymentHistory','PaymentHistoryController@receiveData');




