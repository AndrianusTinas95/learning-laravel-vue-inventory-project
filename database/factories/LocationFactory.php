<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'name'          => $faker->address,
        'lastLocation'  => $faker->address,
        'BU'            => $faker->address,
        'OU'            => $faker->address,
    ];
});
