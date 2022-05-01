<?php

namespace App\ExternalSearch;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class GiantBombClient {

    private Client$client;
    private array $params = [];

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://www.giantbomb.com/api/search',
        ]);

        $this->params = [
            'api_key' => $this->getKey(),
        ];
    }

    public function getKey()
    {
        return config('almanac.services.giantbomb');
    }

    public function find(string $query)
    {
        if (!$this->getKey()) return [];

        return Cache::remember($query, 15, function () use ($query) {
            $results = $this->get($query);

            return array_map(function ($r) {
                $platforms = array_map(function ($p) {
                    return $p->abbreviation;
                }, $r->platforms ?? []);

                return [
                    'title' => $r->name,
                    'meta' => implode(',', $platforms),
                    'year' => isset($r->original_release_date) ? (Carbon::createFromFormat('Y-m-d', $r->original_release_date))->year : null,
                    'poster' => $r->image->screen_large_url,
                    'backdrop' => $r->image->original_url,
                ];
            }, $results);
        });
    }

    private function get(string $query)
    {
        $response = $this->client->request('GET', '', [
            'query' => array_merge($this->params, [
                'query' => $query,
                'resources' => 'game',
                'format' => 'json',
                'limit' => 50,
            ])
        ]);

        return json_decode($response->getBody()->getContents())->results;
    }

}
