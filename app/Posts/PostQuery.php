<?php

namespace App\Posts;

use Illuminate\Http\Request;

class PostQuery {

    public $id;
    public $search;
    public $exact = false;
    public $type;
    public $withTags = false;
    public $year;
    public $month;
    public $day;
    public $path;
    public $withRelated = false;
    public $tags;
    public $platform;

    public function fromRequest(Request $request)
    {
        $tags = $request->input('tags');
        if ($tags && is_array($tags)) $this->tags($tags);

        if ($platform = $request->input('platform')) $this->platform($platform);
        if ($category = $request->input('category')) $this->type($category);

        if ($search = $request->input('search')) {
            $this->search($search);
            if ($request->input('exact') === 'true') $this->exact(true);
        }

        return $this;
    }

    public function applyDates(int $year = null, int $month = null, int $day = null)
    {
        if ($year) $this->year($year);
        if ($month) $this->month($month);
        if ($day) $this->day($day);

        return $this;
    }

    public function id(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function search(string $search = null)
    {
        $this->search = $search;
        return $this;
    }

    public function exact(bool $exact)
    {
        $this->exact = $exact;
        return $this;
    }

    public function type(string $type = null)
    {
        $this->type = $type;
        return $this;
    }

    public function withTags()
    {
        $this->withTags = true;
        return $this;
    }

    public function year(string $year)
    {
        $this->year = $year;
        return $this;
    }

    public function month(string $month)
    {
        $this->month = $month;
        return $this;
    }

    public function day(string $day)
    {
        $this->day = $day;
        return $this;
    }

    public function path(string $path)
    {
        $this->path = $path;
        return $this;
    }

    public function withRelated()
    {
        $this->withRelated = true;
        return $this;
    }

    public function tags(array $tags)
    {
        $this->tags = $tags;
        return $this;
    }

    public function platform(string $platform)
    {
        $this->platform = $platform;
        return $this;
    }


}
