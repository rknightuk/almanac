<?php

namespace Almanac\Http\Controllers;

use Almanac\Posts\Post;
use Almanac\Posts\PostQuery;
use Almanac\Posts\PostRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\Tags\Tag;

class SiteController extends Controller
{
	const PER_PAGE = 25;
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

	public function category(string $type)
	{
		return $this->byKey('type', $type);
	}

	public function platform(string $platform)
	{
		return $this->byKey('platform', $platform);
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

	public function tag(string $tag)
	{
		$query = (new PostQuery())
			->tags([$tag]);

		$posts = $this->postRepository->paginate($query);

		return view('site.index', [
			'posts' => $posts,
		]);
	}

	private function query(): Builder
	{
		return Post::with('tags')
			->where('published', true)
			->orderBy('date_completed', 'desc');
	}

	private function byKey(string $key, string $value)
	{
		$posts = $this->query()
			->where($key, $value)
			->paginate(self::PER_PAGE);

		return view('site.index', [
			'posts' => $posts,
		]);
	}
}
