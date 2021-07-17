<?php

use Faker\Generator as Faker;

$factory->define(App\Models\OfficeRule::class, function (Faker $faker) {
    return [
        'title' =>$faker->title,
        'description' => $faker->text,
    ];
});
