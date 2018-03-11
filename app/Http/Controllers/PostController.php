<?php

namespace Almanac\Http\Controllers;

use Almanac\Http\Requests\CreatePost;
use Almanac\Http\Requests\UpdatePost;
use Almanac\Posts\PathGenerator;
use Almanac\Posts\Post;
use Carbon\Carbon;

class PostController extends Controller
{
	/**
	 * @var PathGenerator
	 */
	private $pathGenerator;

	public function __construct(PathGenerator $pathGenerator)
	{
		$this->pathGenerator = $pathGenerator;
	}

    public function index()
    {
    	$input = request()->input();

	    $query = Post::orderBy('date_completed', 'desc');

	    if ($search = $input['search'] ?? null) {
	    	$query->where('title', 'like', "%$search%");
	    }

	    if ($type = $input['type'] ?? null) {
		    $query->where('type', 'like', "%$type%");
	    }

	    return $query->paginate(10);
    }

	public function show($id)
	{
		return Post::with('tags')->where('id', $id)
			->first();
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

	    $post = Post::find($id);

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
