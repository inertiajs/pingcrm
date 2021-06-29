<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Officerule::class, function (Faker $faker) {
    return [
        'title' => title,
        'description' => text,
    ];
});
