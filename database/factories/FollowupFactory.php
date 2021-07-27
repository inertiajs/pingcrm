<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Followup::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text,
        'priority' => 10,
        'status' => 100,
        'customer_name' => $faker->company,
        'email' => $faker->companyEmail,
        'team_id' => null,
        'phone' => $faker->tollFreePhoneNumber,
        'agreement' => null,
        'maximum_time' => null,
        'meeting_schedule' => null,
    ];
});
