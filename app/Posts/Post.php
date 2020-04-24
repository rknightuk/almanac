<?php

namespace Almanac\Posts;

use Almanac\Attachment;
use Almanac\NumberToAdjective;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        'remote_id',
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
	    'poster',
	    'backdrop',
    ];

    const RATINGS = [
        0 => '&#9733;&#9734;&#9734;',
        1 => '&#9733;&#9733;&#9734;',
        2 => '&#9733;&#9733;&#9733;'
    ];

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function isType(string $type): bool
    {
    	return $this->type === $type;
    }

	public function hasTags(): bool
	{
		return (bool) $this->tags->count();
	}

	public function shouldShowCount(): bool
	{
		return !$this->isQuote() && !$this->isMusic() && $this->time_viewed > 1;
	}

	public function isQuote(): bool
	{
		return $this->type === 'quote';
	}

	public function isMusic(): bool
	{
		return $this->type === 'music';
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
		    case 'quote': return 'quote-left';
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
				return 'listened';
			case 'book': return 'read';
			case 'quote': return '';
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

	public function getSubtitleOutputAttribute()
	{
        $rating = self::RATINGS[$this->rating];

		if (!$this->subtitle && !$this->season && !$this->platform) {
		    return $rating;
        }

		$parts = [];

		if ($this->subtitle) $parts[] = $this->subtitle;
		if ($this->platform) $parts[] = sprintf('<a href="/?platform=%s">%s</a>', strtolower($this->platform), $this->platform);
		if ($this->season) $parts[] = $this->season_string;

		return count($parts) > 0 ? $rating . ' ' . implode(' | ', $parts) : $rating;
	}

	public function getFuturePosts()
	{
		$date = $this->date_completed;
		return $this->relatedPosts->filter(function(Post $r) use ($date) {
			return $date->lt($r->date_completed);
		})->sortByDesc('date_completed');
	}

	public function getPreviousPosts()
	{
		$date = $this->date_completed;
		return $this->relatedPosts->filter(function(Post $r) use ($date) {
			return $date->gt($r->date_completed);
		})->sortByDesc('date_completed');
	}

	public function getTimeViewedAttribute()
	{
		return $this->getPreviousPosts()->count() + 1;
	}

	public function getTwitterPreviewAttribute()
	{
		$date = $this->date_completed->format('l jS F Y');

		if ($this->isQuote()) return $date;

		return ucfirst($this->verb) . ' on ' . $date . ' for the ' . NumberToAdjective::convert($this->time_viewed) . ' time';
	}

}
