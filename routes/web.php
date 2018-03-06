<?php


Auth::routes();

//Route::get('/', 'SiteController@index');

Route::get('/{type?}/{year?}/{month?}/{day?}/{path?}', 'SiteController@index');

Route::group(['prefix' => '/app', 'middleware' => 'auth'], function()
{
	Route::get('/', function () {
		return view('admin');
	});

	Route::get( '/{path?}', function() {
		return view( 'admin' );
	})->where('path', '.*');
});
