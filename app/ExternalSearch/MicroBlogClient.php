<?php

namespace App\ExternalSearch;

use App\Posts\Post;
use GuzzleHttp\Client;

class MicroBlogClient {

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://micro.blog/',
        ]);
    }

    public function createPost(Post $post)
    {
        $title = $post->title;
        if ($post->subtitle)
        {
            $title .= " ($post->subtitle)";
        }
        if ($post->year)
        {
            $title .= " ($post->year)";
        }

        $rating = '';
        foreach (range(1, $post->rating) as $r)
        {
            $rating .= '★';
        }

        $content = "$title - $rating

$post->content
";

        $date = $post->date_completed->toIso8601String();

        $this->client->request('POST', 'micropub?h=entry&mp-destination=https://rknightuk.micro.blog/&content=' . $content . '&published=' . $date . '&category[]=Movies', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('MB_TOKEN'),
                'Accept' => 'application/json',
            ],
        ]);
    }

}
