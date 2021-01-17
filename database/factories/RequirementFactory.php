<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Requirement::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'description' => $faker->text(200),
    ];
});
