<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Document::class, function (Faker $faker) {
    return [

                'title' => $faker->title,
                'customer_name' => $faker->company,
                'document_label' => 1,
                'document_type' => null,
                'digit' => 1,
                'length' => null,
    ];
    
});
