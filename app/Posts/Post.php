<?php

namespace Almanac\Posts;

use Almanac\PostTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	use SoftDeletes;

	protected $table = 'posts';

    protected $fillable = [
	    'id',
	    'type',
	    'path',
	    'title',
	    'subtitle',
	    'content',
	    'link',
	    'rating',
	    'year',
	    'spoilers',
	    'date_completed',
	    'date_started',
	    'time_played',
	    'creator',
	    'episode',
	    'season',
	    'platform',
    ];

	public function tags()
	{
		return $this->hasMany(PostTag::class, 'post_id', 'id');
	}

}
