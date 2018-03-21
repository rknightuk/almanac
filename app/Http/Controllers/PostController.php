<?php

namespace Almanac\Http\Controllers;

use Almanac\Http\Requests\CreatePost;
use Almanac\Http\Requests\UpdatePost;
use Almanac\Posts\PathGenerator;
use Almanac\Posts\Post;
use Almanac\Posts\PostQuery;
use Almanac\Posts\PostRepository;
use Carbon\Carbon;

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
    	$input = request()->input();

	    $query = (new PostQuery())
	        ->search($input['search'] ?? null)
            ->type($input['type'] ?? null)
        ;

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

        return $post;
    }

    public function update(UpdatePost $request, $id)
    {
	    $data = $request->input();

	    $post = $this->postRepository->one($id);

	    unset($data['id']);
	    $data['date_completed'] = $data['date_completed'] ? new Carbon($data['date_completed']) : new Carbon();
	    $data['path'] = $this->pathGenerator->getValidPath(
	    	$data['path'],
		    $data['date_completed'],
		    $id
	    );

	    $post->update($data);

	    $post->syncTags($data['tags']);

	    return $post;
    }

    public function destroy($id)
    {
	    $post = Post::find($id);

	    $post->delete();
    }
}
