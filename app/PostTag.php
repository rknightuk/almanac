<?php

namespace Almanac;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
	protected $table = 'post_tags';

	protected $fillable = [
		'post_id',
		'tag_id',
	];

	protected $appends = [
		'name',
	];

	protected $hidden = [
		'tag',
		'post_id',
		'tag_id',
	];

	public function getNameAttribute()
	{
		return $this->tag->tag;
	}

	public function tag()
	{
		return $this->hasOne(Tag::class, 'id', 'tag_id');
	}
}
