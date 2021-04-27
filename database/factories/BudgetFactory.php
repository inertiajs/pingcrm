<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Budget::class, function (Faker $faker) {
    return [
        'project_name' => $faker->company,
        'resources' => 'Database' ,
        'cost' =>$faker ->randomNumber(2),
        'profit' => null,
        'loss'=> null,
     ];
});
