<?php

namespace Almanac\Posts;

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


}