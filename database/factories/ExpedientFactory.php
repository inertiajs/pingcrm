<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Expedient::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
    ];
});
