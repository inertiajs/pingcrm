<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Education::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'name' => $faker->name,
        'email' => $faker->email,
        'mobile' => null,
        'school' => null,
        'college' => null,
        'percentage' => null,

    ];
});
