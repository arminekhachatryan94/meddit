<?php

use Illuminate\Http\Request;

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

Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::get('/posts', 'PostsController@posts')->name('posts');
Route::get('/posts/{id}', 'PostsController@post')->name('post');
Route::post('/new-post', 'PostsController@create')->name('create-post');
Route::put('/posts/{id}', 'PostsController@edit')->name('edit-post');
Route::delete('/posts/{id}', 'PostsController@delete')->name('delete-post');

Route::post('/posts/{id}/new-comment', 'CommentsController@create')->name('create-comment');
Route::put('/comments/{comment}', 'CommentsController@edit')->name('edit-comment');
Route::delete('/comments/{comment}', 'CommentsController@delete')->name('delete-comment');

Route::get('/{id}/settings', 'SettingsController@settings')->name('settings');
