<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Leave::class, function (Faker $faker) {
    return [
        
        'name' => $faker->comapny,
        'day' => 4
    ];
});
