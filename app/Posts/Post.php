<?php

namespace Almanac\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jonnybarnes\CommonmarkLinkify\LinkifyExtension;
use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use MediaEmbed\MediaEmbed;
use Spatie\Tags\HasTags;

class Post extends Model
{
	use SoftDeletes, HasTags;

	protected $table = 'posts';

	protected $appends = [
		'icon',
	];

	protected $dates = [
		'date_completed',
		'created_at',
		'updated_at',
		'deleted_at',
	];

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
	    'time_played',
	    'creator',
	    'season',
	    'platform',
    ];

    public function isType(string $type): bool
    {
    	return $this->type === $type;
    }

	public function hasTags(): bool
	{
		return (bool) $this->tags->count();
	}

	protected function getHtmlAttribute()
	{
		return (app(ContentManager::class))->convertToHtml($this);
	}

	protected function getPermalinkAttribute(): string
	{
		return sprintf(
			'/%s/%s',
			$this->date_completed->format('Y/m/d'),
			$this->path
		);
	}

    public function getRatingStringAttribute()
    {
    	switch ($this->rating) {
		    case 0: return 'bad';
		    case 1: return 'fine';
		    case 2: return 'good';
	    }
    }

    public function getIconAttribute()
    {
	    switch ($this->type) {
		    case 'movie': return 'film';
		    case 'tv': return 'tv';
		    case 'game': return 'gamepad';
		    case 'music': return 'headphones';
		    case 'book': return 'book';
		    case 'podcast': return 'podcast';
		    case 'video': return 'video';
		    case 'text': return 'file-alt';
	    }
    }

	public function getVerbAttribute()
	{
		switch ($this->type) {
			case 'movie':
			case 'tv':
			case 'video':
				return 'watched';
			case 'game': return 'played';
			case 'music':
			case 'podcast':
				return 'listened to';
			case 'book': return 'read';
			case 'text': return '';
		}
	}

	public function getSeasonStringAttribute()
	{
		if (!$this->season) return '';

		if ($this->type === 'book') return $this->season;

		return 'Season' . ' ' . $this->season;
	}

	public function getRelatedCountAttribute()
	{
		return $this->relatedPosts ? $this->relatedPosts->count() : 0;
	}

}
