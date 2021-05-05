<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Education::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->tollFreePhoneNumber,
        'school' => null,
        'college' => null,
        'higher_education'=>null,
        'percentage' => null,

    ];
});
