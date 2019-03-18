<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->tollFreePhoneNumber,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'region' => $faker->state,
        'country' => 'US',
        'postal_code' => $faker->postcode,
    ];
});
