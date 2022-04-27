<?php


use Almanac\Posts\Post;

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

Route::get('/api/search/movie', 'SearchController@movie');
Route::get('/api/search/tv', 'SearchController@tv');
Route::get('/api/search/game', 'SearchController@game');

Route::get('feed.json', function() {
    $posts = \Almanac\Posts\Post::getFeedItems();
	return [
		'version' => 'https://jsonfeed.org/version/1.1',
		'title' => 'Almanac',
		'home_page_url' => 'https://almanac.rknight.me',
		'feed_url' => 'https://almanac.rknight.me/feed.json',
		'authors' => [
			[
				'name' => 'Robb Knight',
				'url' => 'https://rknight.me',
			]
		],
        'items' => $posts->map(function(Post $post) {
            $attachment = $post->attachments()->first();
            return [
                'id' => $post->id,
                'url' => $post->permalink,
                'title' => $post->title,
                'content_text' => $post->content ?? '',
                'date_published' => $post->date_completed->toIso8601String(),
                'image' => $attachment ? $attachment->real_path : '',
            ];
        }),
	];
});
Route::feeds();
