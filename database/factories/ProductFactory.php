<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Brand;
use App\Model\Category;
use App\Model\Description;
use App\Model\Location;
use App\Model\Manufacture;
use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'quantity'  => $faker->randomDigit,
        'serial'    => $faker->unixTime,
        'status'    => rand(0,1),
        'brand_id'  => function(){
            return Brand::all()->random();
        },
        'manufacture_id'  => function(){
            return Manufacture::all()->random();
        },
        'category_id'  => function(){
            return Category::all()->random();
        },
        'description_id'  => function(){
            return Description::all()->random();
        },
        'location_id'  => function(){
            return Location::all()->random();
        }
    ];
});
