<?php

use Faker\Generator as Faker;

$factory->define(App\UserRole::class, function (Faker $faker) {
    $rand = rand(1, 50);
    if( $rand % 2 == 0 ){
        return [
            'user_id' => 'factory:App\User',
            'role' => '1',
            'created_at' => $faker->dateTime
        ];
    } else {
        return [
            'user_id' => 'factory:App\User',
            'role' => '0',
            'created_at' => $faker->dateTime
        ];
    }
});
