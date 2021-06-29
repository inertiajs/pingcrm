<?php

use Faker\Generator as Faker;

$factory->define(App\Models\OfficeRule::class, function (Faker $faker) {
    return [
        'title' => title,
        'description' => text,
    ];
});
