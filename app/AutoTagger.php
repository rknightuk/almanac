<?php

namespace Almanac;

use Almanac\Posts\Post;
use Almanac\Posts\PostRepository;
use Illuminate\Support\Str;

class AutoTagger {

    const MCU_MOVIES = [
        'Iron Man',
        'The Incredible Hulk',
        'Iron Man 2',
        'Thor',
        'Captain America: The First Avenger',
        'Avengers Assemble',
        'Thor: The Dark World',
        'Iron Man 3',
        'Guardians of the Galaxy',
        'Captain America: Winter Soldier',
        'Avengers: Age of Ultron',
        'Ant-Man',
        'Captain America: Civil War',
        'Doctor Strange',
        'Guardians of the Galaxy Vol. 2',
        'Spider-Man: Homecoming',
        'Thor: Ragnarok',
        'Black Panther',
        'Ant-Man and the Wasp',
        'Avengers Infinity War',
        'Spider-Man: Far from Home',
        'Avengers: Endgame',
        'Captain Marvel',
        'Black Widow',
        'The Eternals',
    ];

    const FAF_MOVIES = [
        'The Fast and the Furious',
        '2 Fast 2 Furious',
        'Fast & Furious: Tokyo Drift',
        'Fast & Furious',
        'Fast Five',
        'Fast & Furious 6',
        'Furious 7',
        'The Fate of the Furious',
        'Fast & Furious Presents: Hobbs & Shaw',
        'F9',
    ];

    const HOT_FUZZ = 'Hot Fuzz';
    const SHAUN = 'Shaun of the Dead';
    const WORLDS_END = 'The World’s End';

    const CORNETTO_MOVIES = [
        self::HOT_FUZZ,
        self::SHAUN,
        self::WORLDS_END,
    ];

    const EDGAR_WRIGHT_MOVIES = [
        self::HOT_FUZZ,
        self::SHAUN,
        self::WORLDS_END,
        'Scott Pilgrim vs. the World',
        'Baby Driver',
    ];

    const KEYWORDS = [
        'Star Wars' => ['star wars'],
        'BTTF' => ['back to the future'],
        'Wizarding World' => ['harry Potter', 'fantastic beasts'],
        'Marvel' => ['x-men', 'deadpool', 'fantastic four'],
    ];

    const TITLES = [
        [
            'title' => self::MCU_MOVIES,
            'tags' => ['MCU', 'Marvel'],
        ],
        [
            'title' => self::CORNETTO_MOVIES,
            'tags' => ['Cornetto Trilogy'],
        ],
        [
            'title' => self::EDGAR_WRIGHT_MOVIES,
            'tags' => ['Edgar Wright'],
        ],
        [
            'title' => self::FAF_MOVIES,
            'tags' => ['Fast and Furious'],
        ],
    ];
    /**
     * @var PostRepository
     */
    private $posts;

    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }

    public function tag(Post $post)
    {
        $existing = $this->posts->findExisting($post);

        if ($existing) {
            $post->attachTags($existing->tags);
            return;
        }

        foreach (self::TITLES as $title) {
            if (in_array($post->title, $title['title'])) {
                $post->attachTags($title['tags']);
            }
        }

        foreach (self::KEYWORDS as $tag => $keywords) {
            if (Str::contains(strtolower($post->title), $keywords)) {
                $post->attachTag($tag);
            }
        }
    }

}
