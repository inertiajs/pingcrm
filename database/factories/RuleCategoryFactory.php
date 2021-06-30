<?php

use Faker\Generator as Faker;

$factory->define(App\Models\RuleCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->text,
        'category' => 1,
        'parent_id' => 12,
        'instructor_id' => 23,
        'priority' =>100,
    ];
});
