<?php

namespace App\Console\Commands;

use App\ExternalSearch\LastFmClient;
use App\ExternalSearch\MicroBlogClient;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MonthlyAlbums extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lastfm:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post top albums for the month';
    private LastFmClient $lastFmClient;
    private MicroBlogClient $microBlogClient;

    public function __construct(LastFmClient $lastFmClient, MicroBlogClient $microBlogClient)
    {
        parent::__construct();
        $this->lastFmClient = $lastFmClient;
        $this->microBlogClient = $microBlogClient;
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $albums = \array_slice($this->lastFmClient->getAlbums('1month'), 0, 5, true);
        $data = [];

        foreach ($albums as $album)
        {
            $data[] = \sprintf(
                '[%s - %s](%s)',
                $album->name,
                $album->artist->name,
                'https://rknight.me',
            );
        }


        $title = \sprintf(
            'Top Albums %s %s',
            Carbon::now()->subMonth()->format('F'),
            Carbon::now()->subMonth()->format('Y')
        );

        $this->microBlogClient->postContent(urlencode(\implode("\n\n", $data)), 'Music', $title);
    }
}
