<?php

use App\Posts\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::resource('/api/posts', \App\Http\Controllers\PostController::class)->middleware('auth');

Route::group(['prefix' => '/app', 'middleware' => 'auth'], function()
{
    Route::get('/', \App\Http\Controllers\AppController::class . '@index');

    Route::get( '/{path?}', \App\Http\Controllers\AppController::class . '@index')->where('path', '.*');
});

Route::get('/tags', \App\Http\Controllers\SiteController::class . '@tags');

Route::get('/{year?}/{month?}/{day?}/{path?}', \App\Http\Controllers\SiteController::class . '@index')->where([
    'year' => '[0-9]+',
    'month' => '[0-9]+',
    'date' => '[0-9]+'
]);

Route::get('/api/search/movie', \App\Http\Controllers\SearchController::class . '@movie');
Route::get('/api/search/tv', \App\Http\Controllers\SearchController::class . '@tv');
Route::get('/api/search/game', \App\Http\Controllers\SearchController::class . '@game');

Route::get('feed.json', function() {
    $posts = \App\Posts\Post::getFeedItems();
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
