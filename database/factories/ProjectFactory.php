<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Project::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text,
        'status' => 1,

        'priority' => 100,
        'creator' => null,
        'due_date' => null,
        'completed_date' => null,
    ];
});
