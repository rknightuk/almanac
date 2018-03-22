<?php

namespace Almanac\Posts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PostRepository {

	const PER_PAGE = 25;

	public function paginate(PostQuery $query = null): LengthAwarePaginator
	{
		$query = $query ?? new PostQuery();

		$db = $this->baseQuery();

		if ($query->search) $this->applySearch($query, $db);
		if ($query->type) $db->where('type', $query->type);
		if ($query->tags) $db->withAnyTags($query->tags);
		if ($query->platform) $db->where('platform', $query->platform);

		$posts = $db->paginate(self::PER_PAGE);

		if ($query->withRelated) {
			$related = Post::whereIn('title', collect($posts->items())->pluck('title'))
				->get();

			$posts->map(function(Post $post) use ($related) {
				if ($post->type === 'text') return $post;
				$this->applyRelatedPosts($related, $post);
				return $post;
			});
		}

		return $posts;
	}

	public function one(PostQuery $query): ?Post
	{
		$db = Post::with('tags');

		if ($query->id) $db->where('id', $query->id);
		if ($query->year) $db->whereYear('date_completed', $query->year);
		if ($query->month) $db->whereMonth('date_completed', $query->month);
		if ($query->day) $db->whereDay('date_completed', $query->day);
		if ($query->path) $db->where('path', $query->path);

		$post = $db->first();

		if ($query->withRelated && $post && $post->type !== 'text') {
			$related = Post::where('title', $post->title)->get();
			$this->applyRelatedPosts($related, $post);
		}

		return $post;
	}

	private function applyRelatedPosts(Collection $related, Post $post)
	{
		$post->relatedPosts = $related
			->where('title', $post->title)
			->where('type', $post->type)
			->where('season', $post->season);
	}

	private function applySearch(PostQuery $query, Builder $db): Builder
	{
		if ($query->exact) return $db->where('title', $query->search);

		return $db->where('title', 'like', "%$query->search%");
	}

	private function baseQuery(): Builder
	{
		return Post::orderBy('date_completed', 'desc');
	}
}