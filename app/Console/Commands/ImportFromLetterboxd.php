<?php

namespace App\Console\Commands;

use App\LetterboxdFetcher;
use Illuminate\Console\Command;

class ImportFromLetterboxd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'almanac:letterboxd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import from a Letterboxd RSS feed';
    /**
     * @var LetterboxdFetcher
     */
    private $letterboxdFetcher;

    /**
     * Create a new command instance.
     *
     * @param LetterboxdFetcher $letterboxdFetcher
     */
    public function __construct(LetterboxdFetcher $letterboxdFetcher)
    {
        parent::__construct();
        $this->letterboxdFetcher = $letterboxdFetcher;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->letterboxdFetcher->run();
    }

}
