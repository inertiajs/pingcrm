<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Task::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text,
        'priority' => 100,
        'status' => 100,
        'user_id' => 1,
        'task_id' => null,
        'project_id' => 1,
        'team_id' => null,
        'creator' => null,
        'due_date' => null,
        'completed_date' => null,
    ];
});
