<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'user_id' => 'factory:App\User',
        'post_id' => NULL,
        'comment_id' => NULL,
        'body' => $faker->paragraph,
        'created_at' => $faker->dateTime
    ];
});
