<?php

namespace App\Http\Controllers;

use App\Posts\PostQuery;
use App\Posts\PostRepository;
use App\Posts\PostType;
use Spatie\Tags\Tag;

class SiteController {

    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(int $year = null, int $month = null, int $day = null, string $path = null)
    {
        $query = (new PostQuery())
            ->withRelated()
            ->applyDates($year, $month, $day)
        ;

        if ($path) return $this->post($query, $path);

        return $this->posts($query);
    }

    private function post(PostQuery $query, string $path)
    {
        $query->path($path);

        $post = $this->postRepository->one($query);

        if (!$post) return view('errors.404', [
            'message' => 'This post might have been moved or deleted',
        ]);

        return view('site.show', [
            'post' => $post,
            'postTypes' => PostType::getConfig(),
        ]);
    }

    private function posts(PostQuery $query)
    {
        $query->fromRequest(request());

        $posts = $this->postRepository->paginate($query);
        $category = request()->input('category');

        return view('site.index', [
            'postTypes' => PostType::getConfig(),
            'posts' => $posts,
            'search' => request()->input('search'),
            'tags' => request()->input('tags'),
            'category' => $category === 'tv' ? 'TV' : ucfirst($category),
            'platform' => request()->input('platform'),
            'year' => $query->year,
            'month' => $query->month,
            'day' => $query->day,
        ]);
    }

    public function tags()
    {
        $tags = Tag::all()->sortBy('name');

        $tags = $tags->map(function(Tag $tag) {
            return $tag->name;
        })->values()->toArray();

        return view('site.tags', [
            'postTypes' => PostType::getConfig(),
            'tags' => $tags,
        ]);
    }
}
