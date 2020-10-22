<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/profile/update', 'Api\ProfileController@update');
Route::get('/follows', 'Api\ProfileController@follows');
Route::post('/toggleFollow', 'Api\ProfileController@toggleFollows');
Route::post('/post', 'Api\PostController@store');
Route::post('/post/avatar', 'Api\PostController@storeAvatar');


