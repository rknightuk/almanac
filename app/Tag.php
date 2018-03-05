<?php

namespace Almanac;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $table = 'tags';

	protected $fillable = [
		'tag',
	];
}
