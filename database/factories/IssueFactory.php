<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Issue::class, function (Faker $faker) {
    return [
        'issue' => $faker->text,
        'description' => $faker->text,
        'status' => 1,
        'priority' => 100,
        'fix' => null,
        'assign' => null,
        'due_date' => null,
        'completed_date' => null,
    ];
});
