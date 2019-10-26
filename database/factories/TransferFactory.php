<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Location;
use App\Model\Product;
use App\Model\Transfer;
use Faker\Generator as Faker;

$factory->define(Transfer::class, function (Faker $faker) {
    return [
        'status'  => rand(0,1),
        'location_id'   => function(){
            return Location::all()->random();
        },
        'product_id'   => function(){
            return Product::all()->random();
        }
    ];
});
