<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Leave::class, function (Faker $faker) {
    return [
        
        'month' => $faker->month,
        'week' => 4
    ];
});
