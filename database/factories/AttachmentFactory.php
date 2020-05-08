<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Almanac\Attachment;
use Faker\Generator as Faker;

$factory->define(Attachment::class, function (Faker $faker) {
    $image = imagecreate(rand(650, 1000), rand(400, 600));
    $bg = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
    imagefill($image, 0, 0, $bg);
    $name = uniqid() . '.png';
    imagepng($image, storage_path('app/public/' . $name));

    return [
        'filename' => $name,
    ];
});
