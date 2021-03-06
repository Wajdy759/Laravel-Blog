<?php

use App\Http\Controllers\PagesController;

Route::get('/blog/{slug}', 'BlogController@getSingle')->where('slug', '[\w\d\-\_]+')->name('blog.single');
Route::get('/blog', 'BlogController@getIndex')->name('blog.index');

Route::get('/', 'PagesController@getIndex');
Route::get('/about', 'PagesController@getAbout');
Route::get('/contact', 'PagesController@getContact');
Route::post('/contact', 'PagesController@postContact');

Route::get('/posts', 'PostController@index')->name('posts.index');
Route::post('/posts', 'PostController@store');
Route::get('/posts/create', 'PostController@create')->name('createPost');
Route::get('/posts/{post}', 'PostController@show')->name('posts.show');
Route::put('/posts/{post}', 'PostController@update');
Route::get('/posts/{post}/edit', 'PostController@edit');
Route::delete('/posts/{post}', 'PostController@destroy');

Route::post('/comments/{post_id}', 'CommentsController@store');
Route::get('comments/{id}/edit' ,'CommentsController@edit')->name('comments.edit');
Route::put('comments/{id}', 'CommentsController@update')->name('comments.update');
Route::delete('comments/{id}', 'CommentsController@destroy')->name('comments.destroy');
Route::get('comments/{id}/delete', 'CommentsController@delete')->name('comments.delete');

// This single line can substitute all the requests to '/posts'
// Route::resource('posts', 'PostController');

Auth::routes();

// DEV ROUTE
Route::get('/logout', 'Auth\LoginController@logout');

// RESOURCE ROUTES
Route::resource('categories', 'CategoryController');
Route::resource('tags', 'TagController');

Route::get('/home', 'PagesController@getIndex')->name('home');
