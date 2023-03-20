<?php

use Faker\Generator as Faker;

$factory->define(RBooks\Models\Customer::class, function (Faker $faker) {
    $name = $faker->lastName;
    return [
        'fullname' => $name,
        'slug' => str_slug($name),
        'birthday' => $faker->date($format = 'Y-m-d', $max = '-35 years'),
        'gender' => rand(0,1),
        'email' => $faker->email,
        'phone' => $faker->tollFreePhoneNumber,
        'updated_user_id' => rand(1,2),
    ];
});
