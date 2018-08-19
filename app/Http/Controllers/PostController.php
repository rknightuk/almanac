<?php

namespace Almanac\Http\Controllers;

use Almanac\Http\Requests\CreatePost;
use Almanac\Http\Requests\UpdatePost;
use Almanac\Posts\PathGenerator;
use Almanac\Posts\Post;
use Almanac\Posts\PostQuery;
use Almanac\Posts\PostRepository;
use Carbon\Carbon;
use Roumen\Feed\Feed;

class PostController extends Controller
{
	/**
	 * @var PathGenerator
	 */
	private $pathGenerator;
	/**
	 * @var PostRepository
	 */
	private $postRepository;

	public function __construct(PathGenerator $pathGenerator, PostRepository $postRepository)
	{
		$this->pathGenerator = $pathGenerator;
		$this->postRepository = $postRepository;
	}

    public function index()
    {
	    $query = (new PostQuery())->fromRequest(request());

    	return $this->postRepository->paginate($query);
    }

	public function show($id)
	{
		return $this->postRepository->one((new PostQuery())->id($id));
	}

    public function store(CreatePost $request)
    {
    	$data = $request->input();

    	unset($data['id']);
	    $data['date_completed'] = $data['date_completed'] ? new Carbon($data['date_completed']) : new Carbon();
	    $data['path'] = $this->pathGenerator->getValidPath(
	    	$data['path'],
		    $data['date_completed']
	    );

        $post = Post::create($data);

        $post->attachTags($data['tags']);

	    $feed = new Feed();
	    $feed->setCache(0, FeedController::FEED_KEY);

        return $post;
    }

    public function update(UpdatePost $request, $id)
    {
	    $data = $request->input();

	    $post = $this->postRepository->one((new PostQuery())->id($id));

	    unset($data['id']);
	    $data['date_completed'] = $data['date_completed'] ? new Carbon($data['date_completed']) : new Carbon();
	    $data['path'] = $this->pathGenerator->getValidPath(
	    	$data['path'],
		    $data['date_completed'],
		    $id
	    );

	    $post->update($data);

	    $post->syncTags($data['tags']);

	    $feed = new Feed();
	    $feed->setCache(0, FeedController::FEED_KEY);

	    return $post;
    }

    public function destroy($id)
    {
	    $post = Post::find($id);

	    $post->delete();
    }
}
