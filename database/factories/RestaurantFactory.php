<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Restaurant::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text,
        'custmer_name' => $faker->company,
        'phone' => $faker->tollFreePhoneNumber,
        'custmer_order' =>null,
        'custmer_address' => null,
        'restaurant_name' => null,
        'bill_no' => null,
        'feedback'=>null,
        'payment_method'=>null,
    ];
});
