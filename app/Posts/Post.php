<?php

namespace App\Posts;

use App\Attachment;
use App\NumberToAdjective;
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
        'link_post',
        'rating',
        'year',
        'spoilers',
        'date_completed',
        'time_played',
        'creator',
        'season',
        'platform',
        'attachment_order',
    ];

    protected $casts = [
        'spoilers' => 'boolean',
        'link_post' => 'boolean',
        'attachment_order' => 'array',
    ];

    const STAR_SELECTED = '<span class="almn-post--titles--sub--rating--selected">&#9733;</span>';
    const STAR_UNSELECTED = '<span class="almn-post--titles--sub--rating">&#9733;</span>';

    const RATINGS = [
        1 => self::STAR_SELECTED . self::STAR_UNSELECTED . self::STAR_UNSELECTED,
        2 => self::STAR_SELECTED . self::STAR_SELECTED . self::STAR_UNSELECTED,
        3 => self::STAR_SELECTED . self::STAR_SELECTED . self::STAR_SELECTED,
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
        return !$this->isMusic() && $this->time_viewed > 1;
    }

    public function isMusic(): bool
    {
        return $this->type === PostType::MUSIC;
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

    public function getLinkHostAttribute()
    {
        return str_replace('www.', '', parse_url($this->link)['host'] ?? $this->link);
    }

    public function getIconAttribute()
    {
        return $this->link_post ? 'link' : PostType::ICONS[$this->type];
    }

    public function getVerbAttribute()
    {
        return PostType::VERBS[$this->type];
    }

    public function getRelatedCountAttribute()
    {
        return $this->relatedPosts ? $this->relatedPosts->count() : 0;
    }

    public function getSubtitleOutputAttribute()
    {
        $rating = self::RATINGS[$this->rating] ?? null;

        if (!$this->subtitle && !$this->season && !$this->platform) {
            return $rating;
        }

        $parts = [];

        if ($this->subtitle) $parts[] = $this->subtitle;
        if ($this->platform) $parts[] = sprintf('<a href="/?platform=%s">%s</a>', strtolower($this->platform), $this->platform);
        if ($this->season && $this->season !== '') {
            $parts[] = $this->type === PostType::BOOK ? $this->season : 'Season' . ' ' . $this->season;
        }

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

        return ucfirst($this->verb) . ' on ' . $date . ' for the ' . NumberToAdjective::convert($this->time_viewed) . ' time';
    }

    public function getSortedAttachments()
    {
        if (empty($this->attachment_order)) return $this->attachments;

        return $this->attachments->sortBy(function(Attachment $attachment) {
            $found = array_search($attachment->id, $this->attachment_order);
            return $found === false ? 9999999999+$attachment->id : $found;
        })->values()->all();
    }

    public static function getFeedItems()
    {
        return Post::orderBy('date_completed', 'desc')->limit(50)->get();
    }
}
