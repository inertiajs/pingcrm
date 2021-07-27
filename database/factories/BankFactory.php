<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Bank::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'phone' => $faker->tollFreePhoneNumber,
        'account_number' => $faker->bankAccountNumber,
        'ifsc_code' => $faker ->randomNumber(7),
        'bank_name' => $faker->company,
        'email' => $faker->unique()->safeEmail,
        ];
});
