<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Project::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->description,
        'priority' => 100,
        'status' => 1,
        'creater' => null,
        'due_date' => null,
        'completed_date' => null,
    ];
});
