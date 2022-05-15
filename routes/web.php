<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerformanceComercialController;
use App\Http\Middleware\SetLocale;

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
    return view('home');
});


Route::group(['middleware' => 'guest'], function () {
    Route::get('/performanceComercial', 'App\Http\Controllers\PerformanceComercialController@index')->name('performanceComercial');
    Route::get('/performanceComercialFilter','App\Http\Controllers\PerformanceComercialController@index_filter')->name('performanceComercialFilter');
    Route::get('/performanceComercialReport','App\Http\Controllers\PerformanceComercialController@report')->name('performanceComercialReport');
    Route::get('/performanceComercialGraphic','App\Http\Controllers\PerformanceComercialController@graphic')->name('performanceComercialGraphic');
    Route::get('/performanceComercialPizza','App\Http\Controllers\PerformanceComercialController@pizza')->name('performanceComercialPizza');
});

