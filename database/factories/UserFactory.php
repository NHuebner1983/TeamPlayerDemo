<?php

use App\User;
use Faker\Generator as Faker;

/**
 * Laravel Default: All user passwords are still set to "secret"
 */
$factory->define(User::class, function(Faker $faker)
{
    return [
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'password'       => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        'remember_token' => str_random(10),
        'api_token'      => $faker->md5,
    ];
});
