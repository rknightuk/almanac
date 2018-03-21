<?php


Auth::routes();

Route::resource('/api/posts', 'PostController')->middleware('auth');

Route::group(['prefix' => '/app', 'middleware' => 'auth'], function()
{
	Route::get('/', 'AppController@index');

	Route::get( '/{path?}', 'AppController@index')->where('path', '.*');
});

Route::get('/tags', 'SiteController@tags');

Route::get('/{year?}/{month?}/{day?}/{path?}', 'SiteController@index')->where([
	'year' => '[0-9]+',
	'month' => '[0-9]+',
	'date' => '[0-9]+'
]);
