<?php


Auth::routes();

Route::group(['prefix' => '/app', 'middleware' => 'auth'], function()
{
	Route::get('/', 'AppController@index');

	Route::get( '/{path?}', 'AppController@index')->where('path', '.*');
});

Route::get('/category/{type}', 'SiteController@category');
Route::get('/platform/{platform}', 'SiteController@platform');
Route::get('/tag/{tag}', 'SiteController@tag');

Route::get('/{year?}/{month?}/{day?}/{path?}', 'SiteController@index');
