<?php

namespace Almanac\Http\Controllers;

use Almanac\Posts\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\Tags\Tag;

class SiteController extends Controller
{
	const PER_PAGE = 25;

	public function index(int $year = null, int $month = null, int $day = null, string $path = null)
	{
		$query = $this->query();

		if ($year) $query->whereYear('date_completed', $year);
		if ($month) $query->whereMonth('date_completed', $month);
		if ($day) $query->whereDay('date_completed', $day);
		if ($path) $query->where('path', $path);

		if ($path) {
			$post = $query->first();

			if (!$post) return view('errors.404', [
				'message' => 'This post might have been moved or deleted',
			]);

			if ($post->type !== 'text') {
				/** @var Collection $related */
				$related = Post::where('title', $post->title)->get();

				$post->relatedPosts = $related
					->where('title', $post->title)
					->where('type', $post->type)
					->where('season', $post->season);
			}

			return view('site.show', [
				'post' => $post,
			]);
		} else {
			if ($search = request()->input('search')) {
				if (request()->input('exact') === 'true') {
					$query->where('title', $search);
				} else {
					$query->where('title', 'like', "%$search%");
				}
			}

			$posts = $query->paginate(self::PER_PAGE);

			$titles = collect($posts->items())->pluck('title');

			/** @var Collection $related */
			$related = Post::whereIn('title', $titles)->get();

			$posts->map(function(Post $post) use ($related) {
				if ($post->type === 'text') return $post;
				$post->relatedPosts = $related
					->where('title', $post->title)
					->where('type', $post->type)
					->where('season', $post->season);
				return $post;
			});

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
		$posts = $this->query()
			->withAnyTags([$tag])
			->paginate(self::PER_PAGE);

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
