<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Status::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
    ];
});
