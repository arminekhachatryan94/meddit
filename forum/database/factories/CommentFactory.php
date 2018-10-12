<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    $rand = rand(1, 50);
    if( $rand % 2 == 0 ){
        return [
            'user_id' => 'factory:App\User',
            'post_id' => NULL,
            'comment_id' => 'factory:App\Comment',
            'body' => $faker->paragraph,
            'created_at' => $faker->dateTime
        ];
    } else {
        return [
            'user_id' => 'factory:App\User',
            'post_id' => 'factory:App\Post',
            'comment_id' => NULL,
            'body' => $faker->paragraph,
            'created_at' => $faker->dateTime
        ];
    }
});
