<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Bank::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'phone' => $faker->tollFreePhoneNumber,
        'account_number' => $faker -> accountnumber,
        'ifsc_code' => $faker -> ifsccode,
        ];
});
