<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Budget::class, function (Faker $faker) {
    return [

        'title' => $faker->title,
        'description' => $faker->text,
        'user_id' => 1,
        'annually_salary' =>null,
        'monthly_salary' => null,
        'data_type' => null,
    ];
});
