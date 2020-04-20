<?php

namespace Almanac;

use Almanac\Posts\PathGenerator;
use Almanac\Posts\Post;
use Almanac\Posts\PostType;
use Carbon\Carbon;
use Html2Text\Html2Text;
use SimpleXMLElement;

class LetterboxdFetcher {

    const FEED = 'https://letterboxd.com/rknightuk/rss/';

    const RATINGS = [
        '½' => 0,
        '★' => 0,
        '★½' => 0,
        '★★' => 0,
        '★★½' => 0,
        '★★★' => 1,
        '★★★½' => 2,
        '★★★★' => 2,
        '★★★★½' => 2,
        '★★★★★' => 2,
    ];

    /**
     * @var PathGenerator
     */
    private $pathGenerator;

    public function __construct(PathGenerator $pathGenerator)
    {
        $this->pathGenerator = $pathGenerator;
    }

    public function run()
    {
        try {
            $data = $this->fetchFeedData();
        } catch (FeedException $e) {
            info('Unable to fetch feed');
            return;
        }

        foreach ($data->item as $item)
        {
            $this->createPost($item);
        }
    }

    /**
     * @return Feed
     * @throws FeedException
     */
    private function fetchFeedData(): Feed
    {
        return Feed::load(self::FEED);
    }

    private function createPost(SimpleXMLElement $item)
    {
        $date = Carbon::createFromFormat(Carbon::RFC1123,  $item->pubDate)->setTimezone('Europe/London');
        $title = $item->title;

        $hasSpoilers = strpos($title, ' (contains spoilers)') !== false;
        if ($hasSpoilers) {
            $title = str_replace(' (contains spoilers)', '', $title);
        }

        list($title, $year, $rating) = $this->extractDataFromTitle($title);

        $post = new Post();
        $post->type = PostType::MOVIE;
        $post->title = $title;
        $post->year = $year;

        $path = $this->makePath($title, $date);

        Post::create([
            'type' => PostType::MOVIE,
            'path' => $path,
            'title' => $title,
            'content' => $this->extractReview((string) $item->description),
            'link' => (string) $item->link,
            'rating' => $ratings[$rating] ?? null,
            'year' => $year,
            'spoilers' => $hasSpoilers,
            'published' => true,
            'created_at' => $date,
            'remote_id' => (string) $item->guid,
            'date_completed' => $date,
        ]);
    }

    private function extractDataFromTitle(string $rawTitle): array
    {
        $hyphenPosition = strrpos($rawTitle, '-', 0);
        $titleAndYear = $hyphenPosition ? substr($rawTitle, 0, $hyphenPosition) : $rawTitle;
        $rating = $hyphenPosition ? substr($rawTitle, $hyphenPosition + 2) : null;

        $lastComma = strrpos($titleAndYear, ',', 0);
        $title = substr($titleAndYear, 0, $lastComma);
        $year = substr($titleAndYear, $lastComma + 2);

        return [$title, $year, $rating];
    }

    private function extractReview(string $rawReview): ?string
    {
        $html = new Html2Text($rawReview);

        $html->getText();

        $review = trim(str_replace('_This review may contain spoilers._', '', $html->getText()));

        // If it says Watched on, there's no review (probably)
        if (strpos($review, 'Watched on') !== false) {
            return null;
        }

        return $review;
    }

    private function makePath(string $title, Carbon $date): string
    {
        $path = str_replace(
            ' ',
            '-',
            strtolower(
                preg_replace("/[^A-Za-z0-9 ]/", '', $title)
            )
        );

        return $this->pathGenerator->getValidPath($path, $date);
    }

}
