<?php

use Faker\Generator as Faker;

$factory->define(RBooks\Models\Product::class, function (Faker $faker) {
    $name = $faker->lastName;
    return ['sku'=> rand(100000, 1000000),
        'name' => $name,
        'slug'=> str_slug($name),
        'publishing_year' => rand(2014, 2018),
        'cover_price' => rand(50000, 180000),
        'sale_price' => rand(30000, 150000),
        'promotion_price' => rand(30000, 150000),
        'description' => 'abc',
        'excerpt' => 'abcdef',
        'quantity' => rand(3, 100) ,
        'status' => rand(0, 1),
        'updated_user_id' => rand(1, 2)
        ];
});