<?php

namespace Almanac\Posts;

class PostType {

    const MOVIE = 'movie';
    const TV = 'tv';
    const GAME = 'game';
	const MUSIC = 'music';
	const BOOK = 'book';
	const PODCAST = 'podcast';
	const VIDEO = 'video';

    const MOVIE_ICON = 'film';
    const TV_ICON = 'tv-retro';
    const GAME_ICON = 'gamepad';
    const MUSIC_ICON = 'headphones';
    const BOOK_ICON = 'book';
    const PODCAST_ICON = 'podcast';
    const VIDEO_ICON = 'video';

	const ICONS = [
        PostType::MOVIE => self::MOVIE_ICON,
        PostType::TV => self::TV_ICON,
        PostType::GAME => self::GAME_ICON,
        PostType::MUSIC => self::MUSIC_ICON,
        PostType::BOOK => self::BOOK_ICON,
        PostType::PODCAST => self::PODCAST_ICON,
        PostType::VIDEO => self::VIDEO_ICON,
    ];

    const VERBS = [
        PostType::MOVIE => 'watched',
        PostType::TV => 'watched',
        PostType::GAME => 'played',
        PostType::MUSIC => 'listened',
        PostType::BOOK => 'read',
        PostType::PODCAST => 'listened',
        PostType::VIDEO => 'watched',
    ];

    const ALL = [
        self::MOVIE,
        self::TV,
        self::GAME,
        self::MUSIC,
        self::BOOK,
        self::PODCAST,
        self::VIDEO,
    ];

    const ICONS_SHRINK_NAV = [
        self::TV,
        self::BOOK,
    ];

    const ICONS_SHRINK_POST = [
        self::TV,
        self::BOOK,
        self::VIDEO,
    ];

    public static function getConfig()
    {
        $disabledTypes = explode(',', config('almanac.disabled_types'));
        $enabledTypes = array_values(array_filter(self::ALL, function($type) use ($disabledTypes) {
            return !in_array($type, $disabledTypes);
        }));

        return array_map(function($type) {
            return [
                'key' => $type,
                'name' => $type === 'tv' ? 'TV' : ucfirst($type),
                'icon' => self::ICONS[$type],
            ];
        },$enabledTypes);
    }

}
