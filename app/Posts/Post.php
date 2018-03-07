<?php

namespace Almanac\Posts;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

class Post extends Model
{
	use SoftDeletes, HasTags;

	protected $table = 'posts';

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

    protected function getHtmlAttribute()
    {
    	$markdown = Markdown::convertToHtml($this->content);
    	$content = $this->wrapSpoilers($markdown);

    	return $content;
    }

    private function wrapSpoilers(string $content)
    {
    	$content = str_replace('[spoiler]', '<span class="almn-post--content__spoiler">', $content);
	    $content = str_replace('[/spoiler]', '</span>', $content);

	    return $content;
    }

	protected function getPermalinkAttribute(): string
	{
		return sprintf(
			'/%s/%s',
			$this->date_completed->format('Y/m/d'),
			$this->path
		);
	}

    public function hasTags(): bool
    {
	    return (bool) $this->tags->count();
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
		    case 'comic': return 'bolt';
	    }
    }

    public function getSeasonStringAttribute()
    {
    	if (!$this->season) return '';

    	$name = 'Season';

    	if ($this->type === 'comic') $name = 'Series';

    	return $name . ' ' . $this->season;
    }

}
