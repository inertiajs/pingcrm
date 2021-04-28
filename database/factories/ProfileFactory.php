<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Profile::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->tollFreePhoneNumber,
        'city' => $faker->city,
        'job' => $faker->jobTitle,
        'nationality' => 'Christian',
         ];
});
