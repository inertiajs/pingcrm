<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Project::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text,
        'status' => 100,
// <<<<<<< Updated upstream
        'priority' => 100,
// =======
//         'priority' => 100,
// >>>>>>> Stashed changes
        'creator' => null,
        'due_date' => null,
        'completed_date' => null,
    ];
});
