<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Address::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'phone' => $faker->tollFreePhoneNumber,
        'address_line1' => $faker->streetAddress,
        'address_line2' => $faker->streetAddress,
        'city' => $faker->city,
        'region' => $faker->state,
        'country' => 'India',
        'postal_code' => $faker->postcode,
    ];
});
