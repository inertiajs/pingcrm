<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Experience::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'company' => $faker->company,
        'start_date' => $faker->Date,
        'end_date' => $faker ->Date,
        'total_experience' =>$faker ->randomNumber(1)
        ];
});
