<?php

namespace Almanac\Http\Controllers;

use Almanac\Posts\PostQuery;
use Almanac\Posts\PostRepository;
use Spatie\Tags\Tag;

class SiteController extends Controller
{
	/**
	 * @var PostRepository
	 */
	private $postRepository;

	public function __construct(PostRepository $postRepository)
	{
		$this->postRepository = $postRepository;
	}

	public function index(int $year = null, int $month = null, int $day = null, string $path = null)
	{
		$query = (new PostQuery())
			->withRelated();

		if ($year) $query->year($year);
		if ($month) $query->month($month);
		if ($day) $query->day($day);
		if ($path) $query->path($path);

		if ($path) {
			$post = $this->postRepository->one($query);

			if (!$post) return view('errors.404', [
				'message' => 'This post might have been moved or deleted',
			]);

			return view('site.show', [
				'post' => $post,
			]);
		} else {
			$tags = request()->input('tags');
			if ($tags && is_array($tags)) $query->tags($tags);

			if ($platform = request()->input('platform')) $query->platform($platform);
			if ($category = request()->input('category')) $query->category($category);

			if ($search = request()->input('search')) {
				$query->search($search);
				if (request()->input('exact') === 'true') $query->exact(true);
			}

			$posts = $this->postRepository->paginate($query);

			return view('site.index', [
				'posts' => $posts,
				'search' => $search,
			]);
		}
	}

	public function tags()
	{
		$tags = Tag::all()->sortBy('name');

		$tags = $tags->map(function(Tag $tag) {
			return $tag->name;
		})->values()->toArray();

		return view('site.tags', [
			'tags' => $tags,
		]);
	}
}
