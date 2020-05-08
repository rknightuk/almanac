<?php

namespace Almanac;

use Almanac\Posts\PathGenerator;
use Almanac\Posts\Post;
use Almanac\Posts\PostType;
use Carbon\Carbon;
use Html2Text\Html2Text;
use SimpleXMLElement;

class LetterboxdFetcher {

    const FEED = 'https://letterboxd.com/%s/rss/';

    /**
     * @var PathGenerator
     */
    private $pathGenerator;
    /**
     * @var AutoTagger
     */
    private $autoTagger;

    public function __construct(PathGenerator $pathGenerator, AutoTagger $autoTagger)
    {
        $this->pathGenerator = $pathGenerator;
        $this->autoTagger = $autoTagger;
    }

    private function getFeed(): string {
        return sprintf(self::FEED, $this->getUser());
    }

    private function getUser(): ?string
    {
        return config('almanac.services.letterboxd');
    }

    public function run()
    {
        if (is_null($this->getUser())) return;

        $content = file_get_contents($this->getFeed());
        $data = simplexml_load_string($content);

        $postsToCreate = []; // get new posts in reverse order
        foreach($data->channel->item as $item) {
            if ($this->shouldCreate($item)) {
                array_unshift($postsToCreate, $item);
            }
        }

        foreach ($postsToCreate as $post)
        {
            $this->createPost($post);
        }
    }

    private function createPost(SimpleXMLElement $item)
    {
        $letterboxdData = $item->children('letterboxd', true);

        $hasSpoilers = $this->doesHaveSpoilers((string) $item->title);

        $date = Carbon::createFromFormat('Y-m-d', (string) $letterboxdData->watchedDate)->setTimezone('Europe/London');

        $rawRating = (int) $letterboxdData->memberRating;
        if ($rawRating === 5) {
            $rating = 3;
        }
        else if ($rawRating >= 3 && $rawRating < 5) {
            $rating = 2;
        } else {
            $rating = 1;
        }

        $title = (string) $letterboxdData->filmTitle;
        $path = $this->makePath($title, $date);

        $post = Post::create([
            'type' => PostType::MOVIE,
            'path' => $path,
            'title' => $title,
            'content' => $this->extractReview((string) $item->description),
            'link' => $link = (string) $item->link,
            'rating' => $rating,
            'year' => (string) $letterboxdData->filmYear,
            'spoilers' => $hasSpoilers,
            'published' => true,
            'created_at' => Carbon::now(),
            'date_completed' => $date,
            'remote_id' => $remoteId = (string) $item->guid,
        ]);

        $this->autoTagger->tag($post);
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

    private function doesHaveSpoilers(string $rawTitle): bool
    {
        return strpos($rawTitle, ' (contains spoilers)') !== false;
    }

    private function shouldCreate(SimpleXMLElement $item): bool
    {
        if (strpos((string) $item->link, '/list/')) {
            return false;
        }

        if (Post::where('remote_id', (string) $item->guid)->first()) {
            return false;
        }

        $publishedDate = Carbon::createFromFormat(Carbon::RFC1123,  $item->pubDate)->setTimezone('Europe/London');

        if ($publishedDate->lt(new Carbon('2020-04-21 23:59'))) {
            return false; // ignoring for existing movies
        }

        return true;
    }

}
