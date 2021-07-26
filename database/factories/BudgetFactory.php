<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Budget::class, function (Faker $faker) {
    return [

        'project_name' => $faker->name,
        'resources' => $faker->company,
        'cost' =>$faker->randomNumber(4),
        'profit' =>null,
        'loss' => null,
       
    ];
});
