<?php

namespace Almanac\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

class Post extends Model
{
	use SoftDeletes, HasTags;

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

}
