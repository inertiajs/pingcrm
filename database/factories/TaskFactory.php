<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Task::class, function (Faker $faker) {
    return [
        'id' => $faker->company,
        'title' => $faker->companyTitle,
        'desciption' => $faker->description,
        'priority' => $faker->Priority,
        'status' => $faker->status,
        'user_id' => $faker->user_id,
        'task_id' => $faker->task_id,
        'project_id' => $faker->project_id,
        'team_id' => $faker->team_id,
        'creator' => $faker->creator,
        'deu_date' => $faker->due_date,
        'completed_date' => $faker->completed_date,
    ];
});
