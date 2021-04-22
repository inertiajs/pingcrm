<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Budget::class, function (Faker $faker) {
    return [
        'project_name' => $faker->company,
        'resources' => null,
        'cost' => $faker->randomNumber(4),
        'profit' => $faker ->randomNumber(2),
        'loss'=> $faker -> randomNumber(2),
        ];
});
