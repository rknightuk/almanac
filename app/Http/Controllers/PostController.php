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
	    return Post::with('tags')
		    ->orderBy('date_completed', 'desc')
		    ->paginate(5);
    }

	public function show($id)
	{
		return Post::with('tags')
			->where('id', $id)
			->first();
	}

    public function store(CreatePost $request)
    {
    	$data = $request->input();

    	unset($data['id']);
	    $data['date_completed'] = $data['date_completed'] ? new Carbon($data['date_completed']) : new Carbon();
	    $data['path'] = $this->pathGenerator->getValidPath(
	    	$data['path'],
		    $data['type'],
		    $data['date_completed']
	    );

        $post = Post::create($data);

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
		    $data['type'],
		    $data['date_completed'],
		    $id
	    );

	    $post->update($data);

	    return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
