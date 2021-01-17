<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Template::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
    ];
});
