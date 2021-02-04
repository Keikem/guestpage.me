<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('comments', 'App\Http\Controllers\CommentController@index');
Route::get('comments/{id}', 'App\Http\Controllers\CommentController@show');
Route::post('comments', 'App\Http\Controllers\CommentController@store');
Route::put('comments/{id}', 'App\Http\Controllers\CommentController@update');
Route::delete('comments/{id}', 'App\Http\Controllers\CommentController@destroy');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'App\Http\Controllers\AuthController@login')->name('login');
    Route::post('register', 'App\Http\Controllers\AuthController@register')->name('register');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh')->name('refresh');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('me', 'App\Http\Controllers\AuthController@me')->name('me');
        Route::post('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
    });
});
