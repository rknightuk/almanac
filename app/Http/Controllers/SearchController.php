<?php

namespace Almanac\Http\Controllers;

use Almanac\ExternalSearch\GiantBombClient;
use Almanac\ExternalSearch\TheMovieDBClient;

class SearchController extends Controller
{
	/**
	 * @var TheMovieDBClient
	 */
	private $movieDBClient;
    /**
     * @var GiantBombClient
     */
    private $giantBombClient;

    public function __construct(TheMovieDBClient $movieDBClient, GiantBombClient $giantBombClient)
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
