<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Almanac\Posts\Platform;
use Almanac\Posts\Post;
use Almanac\Posts\PostType;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $link = rand(0,1) === 1 ? $faker->url : null;
    $type = PostType::ALL[array_rand(PostType::ALL)];
    $content = null;
    if (rand(0, 3) === 1) {
        $content = rand(0, 3) === 1 ? implode('\n\n', $faker->paragraphs(rand(1, 3))) : $faker->sentence;
    }

    return [
        'type' => $type,
        'path' => $faker->slug,
        'title' => implode(' ', $faker->words(rand(1, 7))),
        'subtitle' => rand(0,1) === 1 ? implode(' ', $faker->words(rand(1, 7))) : '',
        'content' => $content,
        'link' => $link,
        'link_post' => $link ? rand(0, 1) === 1 : false,
        'rating' => rand(0, 3),
        'year' => rand(0, 1) === 1 ? $faker->year : null,
        'spoilers' => $content ? rand(0, 3) === 1 : false,
        'date_completed' => $faker->dateTime,
        'creator' => $type === PostType::BOOK && rand(0, 3) === 1 ? $faker->name : null,
        'season' => $type === PostType::TV && rand(0, 1) === 1 ? rand(1, 100) : null,
        'platform' => $type === PostType::GAME ? array_rand(Platform::NAMES) : null,
        'published' => 1,
    ];
});
