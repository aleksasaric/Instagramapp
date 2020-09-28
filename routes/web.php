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

Route::get('/profile/edit', 'ProfileController@edit')->middleware('auth');
Route::get('/profile/{username}', 'ProfileController@show')->middleware('auth');
Route::post('/post', 'Api\PostController@store');
Route::post('/post/avatar', 'Api\PostController@storeAvatar');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
