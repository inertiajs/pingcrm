<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Leave::class, function (Faker $faker) {
    return [
        
        'name' => $faker->company,
        'day' => 4
    ];
});
