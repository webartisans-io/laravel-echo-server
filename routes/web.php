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
    return view('welcome');
});

Route::get('/admin', 'AppsController@index')->name('websockets.admin.index');
Route::get('/admin/create', 'AppsController@create')->name('websockets.admin.create');
Route::post('/admin/store', 'AppsController@store')->name('websockets.admin.store');
Route::get('/admin/{app}/edit', 'AppsController@edit')->name('websockets.admin.edit');
Route::post('/admin/{app}/store', 'AppsController@update')->name('websockets.admin.update');
Route::post('/admin/{app}/destroy', 'AppsController@destroy')->name('websockets.admin.destroy');
