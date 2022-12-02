<?php

namespace App\ExternalSearch;

use GuzzleHttp\Client;

class LastFmClient {

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://ws.audioscrobbler.com/2.0/',
        ]);
    }

    /**
     * @param string $period overall | 7day | 1month | 3month | 6month | 12month
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAlbums(string $period)
    {
        $path = \sprintf('?method=user.gettopalbums&user=rknightuk&api_key=%s&format=json&period=%s', env('LAST_FM_API_KEY'), $period);

        $response = $this->client->request('GET', $path, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents())->topalbums->album;
    }
}
