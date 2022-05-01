<?php

namespace App\Http\Controllers;


use App\ExternalSearch\GiantBombClient;
use App\ExternalSearch\TheMovieDbClient;

class SearchController extends Controller
{
    private TheMovieDbClient $movieDBClient;
    private GiantBombClient $giantBombClient;

    public function __construct(TheMovieDbClient $movieDBClient, GiantBombClient $giantBombClient)
    {
        $this->movieDBClient = $movieDBClient;
        $this->giantBombClient = $giantBombClient;
    }

    public function movie()
    {
        if (!request('query')) return [];

        return $this->movieDBClient->findMovie(request('query'));
    }

    public function tv()
    {
        if (!request('query')) return [];

        return $this->movieDBClient->findTV(request('query'));
    }

    public function game()
    {
        if (!request('query')) return [];

        return $this->giantBombClient->find(request('query'));
    }
}
