<?php

use App\Data\Models\Team\Team;
use Faker\Generator as Faker;
use Bezhanov\Faker\Provider\Team as TeamFaker;

$factory->define(Team::class, function(Faker $faker)
{
    $faker->addProvider(new TeamFaker($faker));

    return [
        'name' => $faker->team,
    ];
});
