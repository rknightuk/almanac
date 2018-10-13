<?php

namespace Almanac\Http\Controllers;

use Almanac\ExternalSearch\TheMovieDBClient;

class SearchController extends Controller
{
	/**
	 * @var TheMovieDBClient
	 */
	private $movieDBClient;

	public function __construct(TheMovieDBClient $movieDBClient)
	{
		$this->movieDBClient = $movieDBClient;
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
}
