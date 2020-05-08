<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Almanac\User::class, function (Faker $faker) {
    static $password;

    return [
        'email' => 'foo@example.com',
        'password' => $password ?: $password = bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});
