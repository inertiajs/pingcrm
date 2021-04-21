<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Restaurant::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text,
        'custmer_name' => $faker->company,
        'phone' => $faker->tollFreePhoneNumber,
        'custmer_address' => null,
        'custmer_order' =>null,
        'bill_no' => null,
        'feedback'=>null,
    ];
});
