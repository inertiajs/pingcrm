<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Task::class, function (Faker $faker) {
    return [
        'id' => $faker->company,
        'title' => $faker->companyTitle,
        'desciption' => $faker->description,
        'user_id' => $faker->user_id,
    ];
});
