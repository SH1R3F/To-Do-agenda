<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'body' => $faker->sentences(1, true),
        'deadline' => '2018-08-' . strval(rand(11, 19)),
        'user_id' => 10
    ];
});
