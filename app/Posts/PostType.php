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

}
