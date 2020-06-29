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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ---------------------
// - LinkWebController -
// ---------------------

Route::post('/links/create', 'LinkWebController@postCreate');
Route::post('/links/delete/{link_id}', 'LinkWebController@postDelete');

// -----------------------
// - StaticWebController -
// -----------------------

Route::get('/', 'StaticWebController@getIndex');