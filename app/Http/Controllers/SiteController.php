<?php

namespace Almanac\Http\Controllers;

use Almanac\Posts\Post;

class SiteController extends Controller
{
	public function index(string $type = null, int $year = null, int $month = null, int $day = null, string $path = null)
	{
		$query = Post::with('tags')
			->where('published', true)
			->orderBy('date_completed', 'desc');

		if ($type) $query->where('type', $type);
		if ($year) $query->whereYear('date_completed', $year);
		if ($month) $query->whereMonth('date_completed', $month);
		if ($day) $query->whereDay('date_completed', $day);
		if ($path) $query->where('path', $path);

		if ($path) {
			$post = $query->first();

			return view('site.show', [
				'post' => $post,
			]);
		} else {
			$posts = $query->paginate(25);

			return view('site.index', [
				'posts' => $posts,
			]);
		}
	}
}
