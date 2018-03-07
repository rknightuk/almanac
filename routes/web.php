<?php


Auth::routes();

Route::group(['prefix' => '/app', 'middleware' => 'auth'], function()
{
	Route::get('/', function () {
		return view('admin');
	});

	Route::get( '/{path?}', function() {
		return view( 'admin' );
	})->where('path', '.*');
});

Route::get('/{year?}/{month?}/{day?}/{path?}', 'SiteController@index');
