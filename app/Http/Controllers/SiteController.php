<?php

namespace Almanac\Http\Controllers;

use Almanac\Posts\Post;
use Illuminate\Database\Eloquent\Builder;

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

			return view('site.show', [
				'post' => $post,
			]);
		} else {
			$posts = $query->paginate(self::PER_PAGE);

			return view('site.index', [
				'posts' => $posts,
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
