<?php

namespace Almanac\Http\Controllers;

use Spatie\Tags\Tag;

class AppController extends Controller
{
    public function index()
    {
	    $tags = Tag::all()->sortBy('name');

	    $tags = $tags->map(function(Tag $tag) {
		    return $tag->name;
	    })->values()->toArray();

	    return view('admin')->with([
		    'config' => [
                'tags' => $tags,
                'search' => [
                    'movie' => (bool) config('almanac.services.moviedb'),
                    'tv' => (bool) config('almanac.services.moviedb'),
                    'game' => (bool) config('almanac.services.giantbomb'),
                ],
                'postTypes' => [ // todo
                    [
                        'key' => 'movie',
                        'name' => 'Movie',
                        'icon' => 'film',
                    ],
                    [
                        'key' => 'tv',
                        'name' => 'TV',
                        'icon' => 'tv-retro',
                    ],
                    [
                        'key' => 'game',
                        'name' => 'Game',
                        'icon' => 'gamepad',
                    ],
                    [
                        'key' => 'music',
                        'name' => 'Music',
                        'icon' => 'headphones',
                    ],
                    [
                        'key' => 'book',
                        'name' => 'Book',
                        'icon' => 'book',
                    ],
                    [
                        'key' => 'podcast',
                        'name' => 'Podcast',
                        'icon' => 'podcast',
                    ],
                    [
                        'key' => 'video',
                        'name' => 'Video',
                        'icon' => 'video',
                    ],
                ],
            ]
	    ]);
    }
}
