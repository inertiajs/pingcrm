<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Project::class, function (Faker $faker) {
    return [
        'title' => $faker->company,
        'description' => $faker->company,
        'priority' => 100,
        'status' => 1,
        'creator' => null,
        'due_date' => null,
        'completed_date' => null,
    ];
});
