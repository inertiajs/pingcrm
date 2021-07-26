<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Issue::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'description' => $faker->text,
        'status' => 1,
        'priority' => 100,
        'solution' => null,
        'assign' => null,
        'due_date' => null,
        'completed_date' => null,
    ];
});
