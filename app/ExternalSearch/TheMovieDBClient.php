<?php

namespace Almanac\ExternalSearch;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class TheMovieDBClient {

	/**
	 * @var Client
	 */
	private $client;

	/**
	 * @var array
	 */
	private $params;

	public function __construct()
	{
		$this->client = new Client([
			'base_uri' => 'https://api.themoviedb.org/3/search/',
		]);

		$this->params = [
			'api_key' => env('THEMOVIEDB_API_KEY'),
			'language' => 'en-US',
		];
	}

	public function findMovie(string $query)
	{
		return Cache::remember($query, 15, function () use ($query) {
			$results = $this->get('movie', $query);

			return array_map(function($r) {
				return [
					'title' => $r->title,
					'year' => $r->release_date ? (Carbon::createFromFormat('Y-m-d', $r->release_date))->year : null,
					'poster' => $r->poster_path,
					'backdrop' => $r->backdrop_path,
				];
			}, $results);
		});
	}

	public function findTV(string $query)
	{
		return Cache::remember($query, 15, function () use ($query) {
			$results = $this->get('tv', $query);

			return array_map(function ($r) {
				return [
					'title' => $r->name,
					'year' => $r->first_air_date ? (Carbon::createFromFormat('Y-m-d', $r->first_air_date))->year : null,
					'poster' => $r->poster_path,
					'backdrop' => $r->backdrop_path,
				];
			}, $results);
		});
	}

	private function get(string $type, string $query)
	{
		$response = $this->client->request('GET', $type, [
			'query' => array_merge($this->params, [
				'query' => $query
			])
		]);

		return json_decode($response->getBody()->getContents())->results;
	}

}
