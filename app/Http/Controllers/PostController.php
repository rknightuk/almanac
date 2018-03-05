<?php

namespace Almanac\Http\Controllers;

use Almanac\Posts\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$data = $request->input();

    	unset($data['id']);
	    $data['date_completed'] = new Carbon($data['date_completed']);

        $post = Post::create($data);

        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	    $data = $request->input();

	    $post = Post::find($id);

	    unset($data['id']);
	    $data['date_completed'] = new Carbon($data['date_completed']);

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
