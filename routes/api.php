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

Route::get('categories', 'API\CategoryAPIController@index')->name('api.category.index');
Route::post('categories', 'API\CategoryAPIController@store')->name('api.category.store');
Route::put('categories/{category}/update', 'API\CategoryAPIController@update')->name('api.category.update');
Route::delete('categories/{category}/delete', 'API\CategoryAPIController@delete')->name('api.category.delete');

Route::get('post', 'API\PostAPIController@index')->name('api.post.index');
Route::post('post', 'API\PostAPIController@store')->name('api.post.store');
Route::put('post/{post}/update', 'API\PostAPIController@update')->name('api.post.update');
Route::delete('post/{post}/delete', 'API\PostAPIController@delete')->name('api.post.delete');

Route::post('/login', 'API\UserAPIController@login')->name('api.login');
