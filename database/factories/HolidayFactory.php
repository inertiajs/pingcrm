<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Holiday::class, function (Faker $faker) {
    return [
        
        'month' => $faker->month,
        'weak' => 4
    ];
});
