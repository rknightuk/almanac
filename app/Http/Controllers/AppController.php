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
	    	'tags' => $tags,
		    'searchConfig' => [
		    	'movie' => (bool) config('almanac.services.moviedb'),
			    'tv' => (bool) config('almanac.services.moviedb'),
                'game' => (bool) config('almanac.services.giantbomb'),
		    ],
	    ]);
    }
}
