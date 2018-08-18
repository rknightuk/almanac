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
    	return $this->movieDBClient->findMovie(request('query'));
    }

	public function tv()
	{
		return $this->movieDBClient->findTV(request('query'));
	}
}
