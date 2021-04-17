<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Address::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'phone' => $faker->tollFreePhoneNumber,
    ];
});
