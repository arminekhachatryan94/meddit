<?php

use Faker\Generator as Faker;

$factory->define(App\Biography::class, function (Faker $faker) {
    return [
        'user_id' => 'factory:App\User',
        'description' => $faker->sentence,
        'created_at' => $faker->dateTime
    ];
});