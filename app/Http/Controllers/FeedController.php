<?php

namespace Almanac\Http\Controllers;

use Almanac\Posts\Post;
use Illuminate\Support\Facades\URL;
use Roumen\Feed\Feed;

class FeedController extends Controller
{
    public function index()
    {
    	$feed = new Feed();

	    $feed->setCache(5, 'main-feed');

	    if (!$feed->isCached()) {
		    $posts = Post::latest()->get();

		    $feed->title = 'Almanac';
		    $feed->description = 'A microblog for all the things I\'ve watched, read, and played';
		    $feed->link = url('feed');
		    $feed->setDateFormat('carbon');
		    $feed->pubdate = $posts[0]->created_at;
		    $feed->lang = 'en';
		    $feed->setShortening(false);

		    foreach ($posts as $post)
		    {
			    $feed->add($post->title, 'Robb Lewis', URL::to($post->permalink), $post->created_at, $post->content, $post->content);
		    }
	    }

    	return $feed->render('atom');
    }
}
