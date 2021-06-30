<?php

use Faker\Generator as Faker;

$factory->define(App\Models\RuleCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->text,
        'category' => null,
        'parent_id' => null,
        'instructor_id' => null,
        'priority' =>100,
    ];
});
