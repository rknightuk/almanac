<?php


Auth::routes();

Route::get('/', function () {
	return view('site');
});

Route::group(['prefix' => '/app', 'middleware' => 'auth'], function()
{
	Route::get('/', function () {
		return view('admin');
	});

	Route::get( '/{path?}', function() {
		return view( 'admin' );
	})->where('path', '.*');
});
